<?php
include "./html/header.php";
require "./html/content.php";
?>

<form name="formu" method="post" action="<?php /* URL DE DESTINATION */ ?>" style="text-align:center;"> 
	<div class="col-md-6">
		<p><label>Identifiant <span class="required">*</span></label>
		<input type="text" name="login" id="login" required />
		</p>

		<p id="clear">&nbsp;</p>	

		<p><label>Mot de passe <span class="required">*</span></label>
		<input type="password" name="password" id="password" required />
		</p>

		<p id="clear">&nbsp;</p>
		
	</div>
	<div class="col-md-5 ">
		<p id="clear">&nbsp;</p> 
		<p class="alert alert-info">Si vous ne parvenez pas à vous connecter, appelez le <strong>0&nbsp;000&nbsp;000&nbsp;000</strong></p>
		<p id="clear">&nbsp;</p>   
		<input type="submit" class="btn btn-success pull-left"  value="CONNEXION">
	</div> 
</form>  


<?php 
include "./html/footer.php";
?>