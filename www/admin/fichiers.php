<?php
require '../admin/config.php';
include '../admin/html/header.php'; 
?>
<h2>Fichiers stockés sur le serveur</h2>
<p>Attention à ne pas supprimer ou renommer de fichier utilisé dans les contenus ou réglages du site !</p>

<iframe  width="100%" height="550" frameborder="0" style="overflow:hidden;"
	src="//<?php echo $_SERVER['SERVER_NAME']; ?>/admin/tinymce/plugins/filemanager/dialog.php?type=0&field_id=IMG&lang=fr_FR&relative_url=1">
</iframe>
 
<?php 
include '../admin/html/footer.php';
?>
