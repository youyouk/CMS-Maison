<?php
require '../admin/config.php';
include '../admin/html/header.php'; 
include '../inc/admin-sitemap.php';
?>
<h2>Pages indexées pour le référencement</h2>
<?php
$requete = $bdd->query('SELECT * FROM SITE_PAGES WHERE VISIBLE LIKE 3 ORDER BY TITRE ASC');

?>
<p>Les <strong><?php echo $requete->rowCount(); ?> pages</strong> ci-dessous ont le statut "<span style="color:#47A447;"><strong>Publié</strong></span>" et viennent d'être ajoutées au <a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/sitemap.xml" target="_blank">Sitemap</a> du site :</p>	

<table class="table table-responsive table-striped table-condensed table-hover">
	<thead>
		<tr style="text-align:left">
			<th>Titre</th>  
			<th>URL</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	while ($liens = $requete->fetch()) { 
		echo '<tr>
				<td><strong>'. $liens['TITRE'].'</strong></td> 
				<td>'. $liens['URL'].'</td> 
				<td style="text-align:center;">
				<a href="..'. $liens['URL'].'" target="_blank" class=" btn  btn-info" ><i class="fa fa-eye fa-1x"></i></a> 
				</td>
			</tr>';
	} 	 
	?>
	</tbody>
</table>
<?php
$sitemap = new SitemapGenerator("http://". $_SERVER['SERVER_NAME'] . "/");

$reponse = $bdd->query('SELECT * FROM SITE_PAGES WHERE VISIBLE LIKE 3 ORDER BY TITRE ASC');
while ($donnees = $reponse->fetch()) { 
	$sitemap->addUrl("http://" . $_SERVER['SERVER_NAME']."".$donnees['URL'],	date('c'),	'daily',	'1');
}
$sitemap->basePath = "../";
$sitemap->createSitemap(); 
$sitemap->writeSitemap(); 
$sitemap->updateRobots(); 
$sitemap->submitSitemap(); 
include '../admin/html/footer.php';
?>
