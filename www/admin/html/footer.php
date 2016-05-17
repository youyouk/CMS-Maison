		
		<p id="clear">&nbsp;</p> 
		</div>
		</div>
		<p id="credits">- CMS Maison par Youyouk - </p> 
	</div>
		<p id="clear">&nbsp;</p>
		<p id="clear">&nbsp;</p>
		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
	<link rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
	<link rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
	<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/bootstrap.min.js"></script> 
	<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/admin.js"></script>
	<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/masonry.js" /></script> 
	<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/admin/tinymce/tinymce.min.js"></script> 
	<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
	<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
	<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
	<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.produits').portfolio({
				cols: 3,
				transition: 'fadeIn'
			});
			//$(".fancybox").fancybox();
			$("img").on("click", function(){
				$.fancybox($(this).attr("src"),{ 
					padding : 0  
				});
			});
			$('.iframe-btn').fancybox({
				'width'	: 880,
				'height'	: 570,
				'type'	: 'iframe',
				'autoScale'   : false
			}); 
			function OnMessage(e){
			  var event = e.originalEvent; 
			   if(event.data.sender === 'responsivefilemanager'){
			      if(event.data.field_id){
			      	var fieldID=event.data.field_id;
			      	var url=event.data.url;
							$('#'+fieldID).val(url).trigger('change');
							$.fancybox.close(); 
							$(window).off('message', OnMessage);
			      }
			   }
			} 
			$('.iframe-btn').on('click',function(){
			  $(window).on('message', OnMessage);
			});
		$("#CONTENU").keyup(function(){
			 var value = $(this).val();
			$(this).val(value.replace('http://<?php echo $_SERVER['SERVER_NAME']; ?>', '..'));   
		}).keyup(); 
		$("#IMG").keyup(function(){
			 var value = $(this).val();
			$(this).val(value.replace('http://<?php echo $_SERVER['SERVER_NAME']; ?>', '..'));   
		}).keyup(); 
		// Dès qu'on bouge ça nettoie l'URL
		$("#colonne").on("mouseover",function(){
			$("#CONTENU").trigger("keyup");
			$("#IMG").trigger("keyup");
		});
		tinymce.init({
			selector: "textarea",
			language : "fr_FR",
			height: 420,  
			plugins: [
			 "advlist autolink link image lists charmap print preview code hr anchor pagebreak",
			 "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
			 "table contextmenu directionality emoticons paste textcolor responsivefilemanager imagetools"
			   ],
			toolbar1: " styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
			toolbar2: " image imagetools media  responsivefilemanager |  forecolor backcolor | undo redo  | link unlink anchor  | print preview code ",
			image_advtab: true ,
			menubar: false,
			imagetools_cors_hosts: ['www.<?php echo $_SERVER['SERVER_NAME']; ?>.fr'],
			imagetools_toolbar: "rotateleft rotateright | flipv fliph | editimage imageoptions",

			external_filemanager_path:"/admin/tinymce/plugins/filemanager/",
			filemanager_title:"Gestionnaire de fichiers" ,
			external_plugins: { "filemanager" : "../tinymce/plugins/filemanager/plugin.min.js"}
		});
		tinymce.init({
			selector: "#imgpicker",  
			language : "fr_FR",
			plugins: "image",
			inline: true,
			menubar: false,
			toolbar: "image",  
			external_filemanager_path:"/admin/tinymce/plugins/filemanager/",
			filemanager_title:"Gestionnaire de fichiers" ,
			external_plugins: { "filemanager" : "../tinymce/plugins/filemanager/plugin.min.js"}
		}); 
	});  
		  
	</script>
	</body>
</html>