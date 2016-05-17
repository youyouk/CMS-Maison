<?php
require '../admin/config.php'; 
include '../admin/html/header.php'; 
/* echo "<pre>";
print_r($_SESSION);
echo "</pre>";
echo $_SERVER['HTTP_USER_AGENT']; */
?>
<script type="text/JavaScript" src="../ressources/js/sha512.js"></script> 
<script type="text/JavaScript" src="../ressources/js/admin.js"></script>
<form action="../inc/admin-login.php" method="post" name="login_form">
	<input name="IP" type="hidden" value="<?php  echo  $_SERVER['REMOTE_ADDR']; ?>" required />  
	<div class="form-group">
		<div class="col-md-6">
			<p id="clear">&nbsp;</p>                    
			<p><label>Email</label>
			<input type="text" name="EMAIL" required />
			</p>
			
			<p id="clear">&nbsp;</p>
			
			<p><label>Mot de passe</label>
			<input type="password" name="MDP" id="MDP" required />
			</p>
			
			<p id="clear">&nbsp;</p>
		
		</div>
		<div class="col-md-5">
		
			<p id="clear">&nbsp;</p>
			<p id="clear">&nbsp;</p>
			<p id="clear">&nbsp;</p>
			<input type="submit" class="btn btn-success" value="Connexion" />
			<a href="../" class="btn btn-default">Retourner sur le site</a>
			<p id="clear">&nbsp;</p>
			<?php if (parametre_contenu(33, $bdd) != 'NON') { ?>
			<p id="clear">&nbsp;</p>
			<a href="nouveau-mdp.php" class=" ">Mot de passe oublié ?</a> 
			<?php } ?> 
			
		</div>
	</div>
</form>

<br/>
<br/>
<br />

<div class="well" ><em><strong>Avertissement :</strong><br />L'accès à cette zone est limité aux seules personnes autorisées. Toutes les connexions à cette interface sont enregistrées, et toute tentative d'accès frauduleux pourra faire l'objet de poursuites judiciaires adaptées.</em></div>

<?php include '../admin/html/footer.php'; ?>