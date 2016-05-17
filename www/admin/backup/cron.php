<?php
@ini_set('log_errors', 1);
@ini_set('display_errors', 0);
@error_reporting(E_ALL | E_NOTICE);
set_time_limit(0);
set_error_handler(create_function('$a, $b, $c, $d', 'throw new ErrorException($b, 0, $a, $c, $d);'), E_ERROR | E_RECOVERABLE_ERROR | E_USER_ERROR | E_USER_WARNING | E_WARNING);

function exception_handler($exception) {
	error_log($exception->__toString());
}

set_exception_handler('exception_handler');

require_once dirname(__FILE__).'/api/external.php';

@ini_set('error_log', Storm::ToAbsolute('/../logs/php_errors.txt'));

$backup_model = StormModel::getInstance('backup_model');
$log_model = StormModel::getInstance('log_model');

$data = $backup_model->getData();
$jobs = $backup_model->getBackupJobsToStart($data);

if (count($jobs) == 0)
{
	echo 'Fin de la routine de sauvegarde.<br />';
	echo '<a href="http://www.URL-DE-VOTRE-SITE.fr">Retour</a>';
	exit;
}

echo /* count($jobs) .  */" Le " . strftime("%d.%m.%Y &agrave; %H:%M") . "<br /><br />--------------------<br />" . PHP_EOL;

foreach ($jobs as $backup)
{
	try
	{
		$logfile = Storm::ToAbsolute('/../logs/'. $backup_model->parseTitle($backup->title) .'.txt');

		$backup->InProgress = true;
		$backup->LastBackup = strtotime('now');
		$backup_model->storeData($data);

		$log_model->Log($logfile, "Sauvegarde auto...");

		echo "<br />Sauvegarde en cours de " . $backup->title . "... <br /><br />--------------------<br />" . PHP_EOL;

		$warnings = $backup_model->backup($backup);

		if (is_array($warnings) && count($warnings) > 0)
		{
			$backup->warnings = $warnings;
			echo "Il y a ". count($warnings) ." avertissement !". PHP_EOL;

			foreach ($warnings as $msg)
			{
				$log_model->Log($logfile, "AVERTISSEMENT : ". $msg);
			}
		}

		$oldCount = $backup_model->clearOlderArchives($backup);
		if ($oldCount !== true && $oldCount !== 0)
		{
			echo "Suppression d'". $oldCount ." archive" . PHP_EOL;
		}

		$backup->InProgress = false;

		$log_model->Log($logfile, "Sauvegarde OK");

		// Send requested emails
		if ($backup->emailMe)
		{
			try
			{
				$mail = new PHPMailer();

				$mail->SetFrom($backup->email, $backup->title);
				$mail->AddAddress($backup->email);
				$mail->Subject = "Sauvegarde ". $backup->title ;
				$mail->Body = "Bonjour\n\n";
				$mail->Body .= "Une nouvelle sauvegarde vient d'être enregistrée sur le serveur.\nL'archive Zip contient une copie complète du site, de la base de données ainsi que des pièces jointes.\n";
				//$mail->Body .= "N'oubliez pas que seules les 10 dernières archives sont conservées, pensez donc à faire des copies régulièrement ;)\n";

				if ($oldCount !== true && $oldCount !== 0)
				{
					$mail->Body .= "\n---------------------------------------\n";
					$mail->Body .= $oldCount ." archive a été effacée.";
				}

				if (is_array($warnings) && count($warnings) > 0)
				{
					$backup->Warnings = $warnings;
					$mail->Body .= "Il y a eu ". count($warnings) ." avertissement(s) :\n";

					foreach ($warnings as $msg)
					{
						$mail->Body .= "• ". $msg ."\n";
					}
				}
				$mail->Body .= "\n---------------------------------------\n";
				$mail->Body .= "".$backup->title ." - Le ". strftime("%d.%m.%Y à %H:%M") ."\n";
				
				if(!$mail->Send())
				{
					$msg = "Erreur du mail automatique : " . $mail->ErrorInfo;
					$log_model->Log($logfile, $msg);

					echo $msg ."\n";
				}
			}
			catch (Exception $e)
			{
				$msg = "Erreur : ". $e->__toString();

				$log_model->Log($logfile, $msg);

				echo $msg ."\n";
			}
		}
	}
	catch (Exception $e)
	{
		echo "<br />Echec de la sauvegarde  :<br />" . PHP_EOL;

		$backup->errors[] = array(
			'start' 	=> $backup->LastBackup,
			'end'		=> strtotime('now'),
			'success'	=> false,
			'message'	=> $e->__toString()
		);
		$log_model->Log($logfile, "Echec de la sauvegarde. Détails : \n" . $e->__toString());
		
		echo "<br />". $e->__toString() ."<br /><br />--------------------<br />" . PHP_EOL;

		$backup->InProgress = false;

		if ($backup->emailMe)
		{
			try
			{
				$mail = new PHPMailer();

				$mail->SetFrom($backup->email, $backup->title);
				$mail->AddAddress($backup->email);
				$mail->Subject =  "ECHEC " . $backup->title ;
				$mail->Body =  "Bonjour\n\n";
				$mail->Body .= "Echec de la sauvegarde de ". $backup->title ." du ". strftime("%d.%m.%Y à %H:%M") . ".\nIl y a eu un problème et le processus n'a pas pu terminer la sauvegarde.\n\n";
				$mail->Body .= "".$backup->title ." - ". strftime("%d.%m.%Y à %H:%M") ."\n\n";

				$mail->Body .= "Détails : ". $e->__toString();

				if(!$mail->Send())
				{
					$msg = "Erreurs : \n" . 
					$mail->ErrorInfo;
					$log_model->Log($logfile, $msg);
						
					echo $msg ."\n";
				}
			}
			catch (Exception $ee)
			{
				$msg = "Erreur : ". $ee->__toString();

				$log_model->Log($logfile, $msg);

				echo $msg ."\n";
			}
		}
	}
}

$backup_model->storeData($data);
echo '<br />Fin de la sauvegarde automatique' . PHP_EOL;

echo "<br />Le " . strftime("%d.%m.%Y &agrave; %H:%M") . "<br /><br />--------------------<br />" . PHP_EOL;
echo 'Sauvegarde auto OK ' . PHP_EOL;