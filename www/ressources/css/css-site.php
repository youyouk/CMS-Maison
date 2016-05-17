<?php
	include_once "../../inc/admin-config.php";
	require_once "../../inc/admin-fonctions.php"; 
	header("Content-type: text/css; charset: UTF-8");
	$couleur_principale = "".parametre(12, $bdd)." !important";
	$couleur_secondaire = "".parametre(13, $bdd)." !important";
	$couleur_background = "".parametre(27, $bdd)." !important";
	if (parametre(19, $bdd) != 'NON') {	
		$symbole = "".parametre(19, $bdd)."";
	} else {	
		$symbole = "";
	}
?>
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700,800);

@font-face {
    font-family: 'amblebold';
    src: url('/../ressources/fonts/Amble-Bold-webfont.eot');
    src: url('/../ressources/fonts/Amble-Bold-webfont.eot?#iefix') format('embedded-opentype'),
         url('/../ressources/fonts/Amble-Bold-webfont.woff') format('woff'),
         url('/../ressources/fonts/Amble-Bold-webfont.ttf') format('truetype'),
         url('/../ressources/fonts/Amble-Bold-webfont.svg#amblebold') format('svg');
    font-weight: normal;
    font-style: normal;

}
@font-face {
    font-family: 'ambleregular';
    src: url('/../ressources/fonts/Amble-Regular-webfont.eot');
    src: url('/../ressources/fonts/Amble-Regular-webfont.eot?#iefix') format('embedded-opentype'),
         url('/../ressources/fonts/Amble-Regular-webfont.woff') format('woff'),
         url('/../ressources/fonts/Amble-Regular-webfont.ttf') format('truetype'),
         url('/../ressources/fonts/Amble-Regular-webfont.svg#ambleregular') format('svg');
    font-weight: normal;
    font-style: normal;

}
@font-face {
	font-family:"Cityof";
	src:url("/../ressources/fonts/cityof.eot?") format("eot"),url("/../ressources/fonts/cityof.woff") format("woff"),url("/../ressources/fonts/cityof.ttf") format("truetype"),url("/../ressources/fonts/cityof.svg#Cityof") format("svg");
	font-weight:normal;
	font-style:normal;}

body {
  font-family: 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;
  font-size: 13px;
  line-height: 17px;
  color: #505050;
  margin: 0;
  padding: 0; 
  <?php  if (parametre(11, $bdd) != 'NON') { ?>
	background: <?php echo parametre(27, $bdd);?> url('/<?php echo parametre(11, $bdd); ?>') <?php if (parametre(26, $bdd) != 'repeat') { echo 'no-repeat'; } ?> center fixed ;
	<?php if (parametre(26, $bdd) != 'repeat') { echo 'background-size:cover;'; } ?>
	background-position: 50% 50%;
  <?php } else { ?>
	background-color: <?php echo $couleur_background; ?>;
  <?php } ?> 
}

body a img, map , body img {
  border: 0;
}

.zoom {
  box-shadow: 0px 0px 10px #a5a5a5;
  -webkit-box-shadow: 0px 0px 10px #a5a5a5;
  -moz-box-shadow: 0px 0px 10px #a5a5a5;
  border: 4px solid white;
-webkit-transition-duration: .25s;
       -moz-transition-duration: .25s;
         -o-transition-duration: .25s;
            transition-duration: .25s;
    -webkit-transition-timing-function: ease-in;
       -moz-transition-timing-function: ease-in;
         -o-transition-timing-function: ease-in;
            transition-timing-function: ease-in;
 /*  max-height:320px;
  width:auto;
  max-width:100%; */
	margin: 2% auto;
	
}
.zoom:hover {
  box-shadow: 0px 0px 4px #dcdcdc;
  -webkit-box-shadow: 0px 0px  4px #dcdcdc;
  -moz-box-shadow: 0px 0px  4px #dcdcdc;
  border: 4px solid white;
cursor:pointer; 
}
<?php if (parametre(24, $bdd) != 'NON') { ?>
#colonne img {
  box-shadow: 0px 0px 10px #a5a5a5;
  -webkit-box-shadow: 0px 0px 10px #a5a5a5;
  -moz-box-shadow: 0px 0px 10px #a5a5a5;
  border: 4px solid white;
-webkit-transition-duration: .25s;
       -moz-transition-duration: .25s;
         -o-transition-duration: .25s;
            transition-duration: .25s;
    -webkit-transition-timing-function: ease-in;
       -moz-transition-timing-function: ease-in;
         -o-transition-timing-function: ease-in;
            transition-timing-function: ease-in;
 /*  max-height:320px;
  width:auto;
  max-width:100%; */
	margin: 2% auto;
	
}
#colonne img:hover {
  box-shadow: 0px 0px 4px #dcdcdc;
  -webkit-box-shadow: 0px 0px  4px #dcdcdc;
  -moz-box-shadow: 0px 0px  4px #dcdcdc;
  border: 4px solid white;
cursor:pointer; 
}
<?php } else { ?>
#colonne img {
	margin: 2% auto;
 /*  box-shadow: 0px 0px 10px #a5a5a5;
  -webkit-box-shadow: 0px 0px 10px #a5a5a5;
  -moz-box-shadow: 0px 0px 10px #a5a5a5; */
}
<?php } ?>

#colonne { 
  <?php if (parametre(20, $bdd) == 'SIDEBAR') { ?> 
	width: 66.5%;
    padding: 0% 2% 3% 2%; 
    background-color: white; 
  <?php } else { ?>	
	  <?php  if (parametre(11, $bdd) != 'NON') { ?> 
		width: 96%;
		padding: 0% 2% 3% 2%; 
		background-color: white; 
	  <?php } else { ?>
		width: 96%;
		padding: 0% 2% 3% 2%; 
		background-color: white;  
	  <?php } ?>
  <?php } ?>
}

.pleinelargeur { 
    border-left: none !important;
    margin: 0 !important;
}
.pleinelargeur p,  .pleinelargeur h2,  .pleinelargeur blockquote {
    margin-left: 4%;
    margin-right: 4%;
}
.pleinelargeur iframe{
    max-width: 92% !important;
    border: none; 
    margin-left: 4%;
}
body a:hover {
  text-decoration: none;
}

#conteneur {
  margin: 0 auto;
  
  <?php  if (parametre(11, $bdd) != 'NON') { ?>
	width: 80%;
	max-width: 900px;
	padding-top: 0%;
	-webkit-box-shadow: 0px 2px 7px #333;
	-moz-box-shadow: 0px 2px 7px #333;
	box-shadow: 0px 2px 7px #333;
  <?php  } else { ?>
	width: 80%;
    max-width: 900px;
	padding: 0 0 0%;
	margin: 10px auto 0;
  
  <?php  } ?>
  
  
  /* background-color: <?php echo $couleur_background; ?>; */
    background-color: #F3f2ee !important;
}

#sdbmenu { 
  width: 26%;
  margin: 0 0% 0 1.5%;
  padding: 0;
  float: left;
  display: block;
  position: relative;
  background-color: #f3f2ee;
}

#infos { 
}

hr {
  height: 1px;
  margin: 7px 0;
  background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.1), rgba(0,0,0,0));
  background-image: -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.1), rgba(0,0,0,0));
  background-image: -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.1), rgba(0,0,0,0));
  background-image: -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.1), rgba(0,0,0,0));
  border: 0;
}

#titre {
  display: none;
}

#actualite {
  background: transparent url(/../img/Actus.png) no-repeat;
  background-position: 100% bottom;
  height: 165px;
  margin-right: -10px;
  padding-top: 70px;
  margin-top: -25px;
}

#actualite h3 {
  margin: 0;
  padding: 0;
  font-size: 1em;
}

#actualite .date {
  color: gray;
  font-weight: bold;
}

#actualite a { 
}

#cache {
  overflow-x: hidden;
  overflow: hidden;
  height: 137px;
  width: 84%;
  margin: -5px 0 0px 4px;
}
img {
  /* width: auto; */
  height: auto;
  max-width: 100%;
  margin: 0 auto; 
}

#cache img {
  margin-right: 5px;
  float: left;
  max-width: 214px;
}
iframe, object, embed {
        max-width: 100%;
}
#logo {  
	width: 26%;
    display: inline-block;
    vertical-align: middle;
    margin: 5% 2%;
    padding: 0 ;
}

#entete {
  display: inline-block;
  position: relative;
  background-color: #FFF;
  width: 100%;
    margin: 0;
	padding: 2% 0px 1%;
  text-align: center;
}

#entete #lien {
  display: block;
  margin: 5% auto;
  max-height: 175px;
}

#bandeau {
  float: right;
}

.encart-bovin, .encart, .middle {
width: 98%;
    border: 0px solid #cfcfcf;
    padding: 1%;
    margin: 0 0 2%;
}
.encart-bovin h2 {
margin:0.5em 0 0.5em 0;
}
.encart {
background-color: #f5f5f5;
}
.encart-bovin {
background-color: #f5f5f5;
}
.navbar-nav {
    margin: 0px -15px 0;
}
.navbar-default .navbar-collapse, .navbar-default .navbar-form {
    border-color: <?php echo $couleur_principale; ?>; 
}
.navbar-default {
  background-color: <?php echo $couleur_principale; ?>;
  border-bottom: 2px solid <?php echo $couleur_secondaire; ?>;
  /* -webkit-box-shadow: 0 7px 7px rgba(0, 0, 0, .3);
  box-shadow: 0 7px 7px rgba(0, 0, 0, .3); */
	transition: ease 0.3s;
	-webkit-transition: ease 0.3s;
	-moz-transition: ease 0.3s;
}

.navbar-default .navbar-nav > li > a, .navbar-default .navbar-nav > li > a:active {
  color: white !important;
  font-weight: bold;
}

.navbar-default .navbar-nav > li.active > a, .navbar-default .navbar-nav > li.dropdown.open > a { 
}

.navbar-default .navbar-nav > li:hover {
  color: white;
  background-color: <?php echo $couleur_secondaire; ?>;
	transition: ease 0.3s;
	-webkit-transition: ease 0.3s;
	-moz-transition: ease 0.3s;
}
.dropdown-header {
    display: block;
    padding: 3px 20px;
    font-size: 1.5em;
    line-height: 1.42857143;
    color: #999;
    white-space: nowrap;
    text-align: center;
    background-color: #f5f5f5;
}

.dropdown-menu > li > a {
    display: block;
    padding: 8px 16px;
}

.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
    color: #fff;
    text-decoration: none;
    background-color: <?php echo $couleur_secondaire; ?>;
}
.navbar-default .navbar-toggle {
  border-color: white;
}

.navbar-nav > li > .dropdown-menu {
  margin-top: 0px;
}

.dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus {
  background-color: <?php echo $couleur_secondaire; ?>;
}
.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
    color: white !important;
    background-color: <?php echo $couleur_secondaire; ?>;
}

.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
  color: #555;
  background-color: <?php echo $couleur_secondaire; ?>;
}

.navbar-default .navbar-toggle .icon-bar {
  background-color: white;
}
.slides img {
   /*  max-height: 360px !important; */
}
.carousel-inner {
	position: relative;
    width: 100%;
	<?php if ((parametre(29, $bdd) == 'HOME') && (parametre(20, $bdd) != 'SIDEBAR')) { ?> 
    max-height: 309px;
	<?php } else { ?>
    max-height: 259px; 
	<?php } ?>
    overflow: hidden;  
}
.carousel-inner img { 
    max-height: 360px !important;
	margin:0px auto;	
}
.carousel-indicators {
  bottom: -22px;
} 
.carousel-indicators li {
	background-color:   <?php echo $couleur_secondaire; ?> ;
}
.carousel-indicators .active{
	background-color:   <?php echo $couleur_principale; ?> ;
}
.carousel-legende {
    position: absolute;
    width: 34%;
	<?php if ((parametre(29, $bdd) == 'HOME') && (parametre(20, $bdd) != 'SIDEBAR')) { ?> 
    max-height: 303px;
	<?php } else { ?>
    max-height: 253px; 
	<?php } ?>
    top: 0;
    float: right;
    right: 0;
    height: 100%!important;
    color: #6b6b6b;
    font-size: 1.7em;
    padding: 3% 3% 0% 3%;
    margin-top: 0;
    line-height: 18px;
    box-sizing: inherit;
    text-align: center;
    background-color: rgba(255,255,255, .6);
	transition: ease 0.3s;
	-webkit-transition: ease 0.3s;
	-moz-transition: ease 0.3s;
}
.carousel-legende:hover {
    background-color: rgba(255,255,255, .8);
	transition: ease 0.3s;
	-webkit-transition: ease 0.3s;
	-moz-transition: ease 0.3s;
}

.carousel-legende h4 { 
	color:<?php echo $couleur_principale; ?>;
	text-shadow:2px 2px 2px #5a5a5a; 
	width: 100%!important;
    display: block; 
    text-align: center;
    padding: 15px 0;
    margin: 10px 0;
	transition: ease 0.3s;
	-webkit-transition: ease 0.3s;
	-moz-transition: ease 0.3s;
}
.carousel-legende:hover > .carousel-legende h4  {
	color:   <?php echo $couleur_secondaire; ?> ;
	transition: ease 0.3s;
	-webkit-transition: ease 0.3s;
	-moz-transition: ease 0.3s;
}
.carousel-legende .description {
	color:   #505050 ;
	text-shadow:none;  
	font-size: .7em;
	text-align: center!important;
	width: 100%!important;
	display: block;
	padding:  10px 0px;
	margin-top: -10px; 
    margin-bottom: 20px;
}

#banniere { 
    width: 66%;
    display: inline-block;
    vertical-align: top;
    margin: 0px 2% 0px 1%;
    padding: 0px;
}

img#banniere {
   width: 100%;
	margin:0 auto !important;
    /* padding: 10px;
    max-width: 100%; */
    box-shadow: none;
    border: none;
	height:auto;
    /*max-height: none !important;  */
}
img#banniere:hover {
	border:none!important;
	cursor:pointer;
} 
#banniere a:hover img {
	border:none!important;
	cursor:pointer;
} 

.carousel-indicators li { 
    border: 3px solid #F5F4F1;
}
ul.dropdown-menu li.inactif a {
	color: #505050 ;
	cursor:default !important;
	background-color:white;
	font-weight: bold;

}
.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus { 
    background-color: #f5f5f5;
}
#fil-ariane {
  font-style: italic;
  margin: 5px 0 0 0;
}

#fil-ariane a {
  font-style: italic;
  color: black;
}

#contenu {
  margin: 0 0 0 0;
  padding: 0 0 0 0;
  position: relative;
  height: 100% !important;
  background-color: white;
  display: block;
  position: relative;
}

#sous-navigation { 
}

#sous-navigation h2 {
  margin-bottom: 0.3em;
}

#sous-navigation ul {
  margin: 0 0 1.5em 0;
  padding: 0 0 0 5px;
}

#sous-navigation ul li {
  list-style-type: none;
  padding: 5px 2px;
}

#sous-navigation, #sous-navigation a {
  color: #6F7072;
}

#sous-navigation a {
  text-decoration: none;
  font-weight: bold;
}

#sous-navigation  ul li:hover, #sous-navigation  ul li:hover a, #sous-navigation a:hover {
  font-weight: bold !important;
  color: white !important;
  text-decoration: none !important;
  background-color: <?php echo $couleur_principale; ?> !important;
}

#sous-navigation ul li.active, #sous-navigation ul li.active a, #sous-navigation a.active {
  font-weight: bold !important;
  color: white !important;
  text-decoration: none !important;
  background-color: <?php echo $couleur_principale; ?> !important;
}

h1 {  
	font-family:"Cityof", 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;
	margin-top: 0;
	margin-bottom: 20px;
	font-weight: 800; 
	padding: 20px 0;
	width: 100%;
	text-align: center;
	color: #6F7072;
	background-color: #f3f2ee;
	font-size: 1.8em;
	line-height: 1.3em;
	border-radius:4px
}

h2 {
	font-family:"Cityof", 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;
  text-transform: uppercase;
  font-weight: bold;
  padding-left: 3px; 
  font-size: 1.7em;
  color: <?php echo $couleur_principale; ?>;
  /* margin: 0.5em auto 0.5em; */
    margin-top: 40px !important;
}

h2::before {
  margin: -3px 6px 0 -3px;
  content: "<?php echo $symbole; ?>";
  color: <?php echo $couleur_principale; ?>;
  font-size: .5em;
  text-decoration: none!important;
  vertical-align: middle;
  cursor: default;
  
 font-family: FontAwesome;
  font-weight: normal;
  font-style: normal;
  display: inline-block;
  text-decoration: inherit;
}

#infos h2 {
    font-family: "Cityof", 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;
    text-transform: uppercase;
    font-weight: bold;
    padding-left: 0; 
    background:none;
    font-size: 1em;
	color:#6C6D6F;
     margin: 0;
}

h1 {
	text-align: center;
    margin:  0;
	background: url('/../img/line.gif') center repeat-x;
	font-weight:inherit;
	padding:20px 0;
	color:#30363f;
	text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.25);
	text-transform:uppercase;
}

h1 span {
	background: #FFF;
	padding: 0 ;
	text-transform:uppercase;
}
h2{
	border-bottom-color:#F1F1F1;
	border-bottom-style:double;
	border-bottom-width:3px;
	font-size: 1.5em;
  }
#colonne h3 {
  background-color: #f5f5f5;
      padding: 2% 0;
   /*  margin: 2% 4% 2% 4%; */
   margin: 2% 0% 0%;
  font-size: 1.3em;
  text-align: center;
    font-weight: bold;
}

h4 {
  font-weight: bold;
  font-size: 1.2em;
}

p {
  margin: 1% 0 3%; 
  font-size: 16px;
  line-height: 24px;
}
#colonne p { 
  text-align: justify; 
}

p.liste {
  margin-bottom: 0;
}

p.lienImg {
  margin: 10px auto;
}

.open_close {
  color: #23527c;
}

.open_close:hover {
  text-decoration: none;
}

h2.open_close {
  text-decoration: none;
}

h2.open_close:hover {
}
.panel-title > a:hover,.panel-title > a {
    text-decoration: none;
}

.panel-default:hover > .panel-heading {
    color: #333;
    background-color: #f3f2ee;
    border-color: #ddd;
}

.close, .plus-plus {
  position: absolute;
  top: -13px;
  font-size: .9em;
  color: gray;
  line-height: 10px;
  padding: 1px 2px 1px 3px;
  font-weight: bold;
  border: 1px solid gray;
  float: right;
  margin-top: 3px;
  background-color: white;
}

.close {
  padding-top: 2px;
  padding-right: 3px;
}

.plus-plus {
  position: relative;
  color: <?php echo $couleur_principale; ?>;
}

div.close:hover {
  background-color: #f3f2ee;
}
blockquote {
    padding: 10px 20px;
    margin: 0 0 20px;
    font-size: 1.25em;
    font-style: italic;
    line-height: 1.5em;
    border-left: 5px solid #eee;
}
.log-box {
  padding:5px;
  position:absolute;
  right:0;
  text-align:center;
  top:0;
  z-index:9;
  zoom:1;
}
.contact-box, .log-box .container {height: 100%;}

.contact-box, .log-box h1, .log-box p {
  background-color:#30363f;
  border-radius:4px;
  -webkit-border-radius:4px;
  -moz-border-radius:4px;
  color:#FFFFFF;
  opacity:0.7;
  padding:5px 10px;
}

.contact-box, .log-box h1:hover, .log-box p:hover {
	filter: alpha(opacity=100);
	opacity: 1;
}



.log-box-mobile {
  padding:5px;
  position:absolute;
  width:98%;
  right:0;
  text-align:center;
  top:0;
  z-index:9;
  zoom:1;
}
.contact-box, .log-box-mobile .container {height: 100%;}

.contact-box, .log-box-mobile h1, .log-box-mobile p {
  background-color:#30363f;
  border-radius:4px;
  -webkit-border-radius:4px;
  -moz-border-radius:4px;
  color:#FFFFFF;
  opacity:0.7;
  padding:5px 10px;
}

.contact-box, .log-box-mobile h1:hover, .log-box-mobile p:hover {
	filter: alpha(opacity=100);
	opacity: 1;
}
#colonne ul { 
    text-align: left;
}
.well {
  display:inline-block;  
   /*  margin-left: 2%;  */
}

#sidebar { 
	width: 27.5%;
    padding: 0% 0% 3% 2%;
    float: left;
    background-color: #f3f2ee;
    margin: 0;
    margin-top: 0px;
	display: inline-block;
	position: relative; 
    border-radius: 0 4px 4px 0;
}
#sidebar h2{ 
	font-size: 1.2em;
    margin-bottom: -15px;
}
#sidebar a{ 
	color:#7B7C7E;
    padding: 5px;
}
#sidebar ul li ul li, #sidebar ul li  {  
	padding: 2px 5px;
    line-height: 1.5em;
}
#sidebar a.active, #sidebar a:hover, #sidebar li.active, #sidebar ul li ul li a:hover, #sidebar ul li ul li ul li a:hover { 
	background-color: <?php echo $couleur_principale; ?>;
	color:white !important;
}
#sidebar ul li ul li a , #sidebar ul li ul li ul li a { 
padding: 5px;
}
#sidebar a {
	text-decoration: none;
	font-weight:bold;
	width:100%;
    display: inline-block;
}
#sidebar a:hover {
	/* */
}

/* #sidebar ul {
	margin: 0 0 1.5em 0;
	padding: 0 0 0 5px;
	background-color:white !important;
} 
#sidebar ul:hover { 
	background-color:white !important;
}
*/
#sidebar ul li {
	list-style-type: none;
	/* padding: 5px 2px; */
}

#sidebar ul li:hover, #sidebar ul li:hover a  {
	/* font-weight:bold !important;
	color:white !important;
	text-decoration:none !important;
	background-color:<?php echo $couleur_principale; ?>; */
}
#sidebar ul li.active, #sidebar ul li.active a, #sidebar a.active{
	font-weight:bold !important;
	color:white !important;
	text-decoration:none !important;
	/* background-color:<?php echo $couleur_principale; ?>; */
}

#colonne { 
	/* width: 66.5%;
    padding: 0% 0% 3% 2%;  */
	margin: 0;
	display: inline-block;
	position: relative;
}

#colonne ul {
	padding: 0 0 0 6%;
    margin: 3%;
    width: 91%;
}

#colonne ul li {
  margin: 0;
  padding: 0;
    font-size: 16px;
    line-height: 24px;
}

#colonne .encart ul li {
  margin: 0 0 0 20px;
  padding: 10px;
  font-size: 1.2em;
  list-style: initial;
}

#colonne p a  {
	color: <?php echo $couleur_principale; ?> ; /* */
	font-weight:bold;
	border-bottom: 1px dotted <?php echo $couleur_principale; ?>;
	transition: ease 0.3s;
	-webkit-transition: ease 0.3s;
	-moz-transition: ease 0.3s;
}
#colonne p a:hover  {
	color: <?php echo $couleur_secondaire; ?> ; /* */
	font-weight:bold;
	border-bottom: 1px dotted <?php echo $couleur_secondaire; ?>;
	transition: ease 0.3s;
	-webkit-transition: ease 0.3s;
	-moz-transition: ease 0.3s;
}
#colonne p a.btn  {
	color: <?php echo $couleur_secondaire; ?> ; /* */
	font-weight:bold;
	border-bottom: 0px dotted <?php echo $couleur_secondaire; ?>;
}
#colonne a.btn.btn-info  { 
	border-bottom-width: 0px !important;
	border-bottom-style: solid !important; 
   color: #ffffff !important;
}
.nav-tabs { 
    margin: 0 !important;
}
.nav-tabs > li > a { 
	border-bottom-width: 0px !important;
	border-bottom-style: solid !important; 
}

#colonne ul li.open_close::before {
  margin: 0 15px 0 0;
  content: "+";
  font-size: 2em;
  text-decoration: none!important;
  vertical-align: sub;
  cursor: default;
}

a.plus-info, .plus-info {
  color: <?php echo $couleur_principale; ?>;
  font-weight: bold;
  text-decoration: none;
}

.form-control { 
    width: auto;
}


.page-header {
    padding-bottom: 0;
    margin: 0;
    border-bottom: 1px solid #eee;
}
#back-to-top {
    display: none;
    position: absolute;
    right: 0px;
	    bottom: -6px;
    right: -1px;
    border-left: 1px solid #f5f5f5;
    padding: 6px 9px 6px;
    text-align: center;
    font-size: 21px;
    color: #fff;
    cursor: pointer;
    background-color: <?php echo $couleur_principale; ?>;
    line-height: 1em;
    z-index: 999999999;
    -ms-filter: "alpha(opacity=80)";
    filter: alpha(opacity=80);
    opacity: .8;
    /* -webkit-box-shadow: 0px 0px 3px #333;
     -moz-box-shadow: 0px 0px 3px #333;
          box-shadow: 0px 0px 3px #333; */
}
#back-to-top:hover {
    background-color: <?php echo $couleur_secondaire; ?>;
    -ms-filter: "alpha(opacity=100)";
    filter: alpha(opacity=100);
    opacity: 1
}

#information {
  float: left;
  width: 20%;
}

#information img {
  border: 1px solid gray;
  padding: 2px;
}

#footercarousel {
background-color: #F3F2EE;
    margin: 20px auto -50px;
    padding: 10px 10%;
}
#prefooter {
  text-align:center;
  background-color:#f3f2ee;
      padding: 1% 0 3%;
}

#infofooter a {
  text-decoration: none!important;
  color: #c4c4c4!important;
}

#video {
  width: 100%; 
}

.rotation {
    -webkit-animation-name: spin;
    -webkit-animation-duration: 4000ms;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-timing-function: linear;
    -moz-animation-name: spin;
    -moz-animation-duration: 4000ms;
    -moz-animation-iteration-count: infinite;
    -moz-animation-timing-function: linear;
    -ms-animation-name: spin;
    -ms-animation-duration: 4000ms;
    -ms-animation-iteration-count: infinite;
    -ms-animation-timing-function: linear;
    
    animation-name: spin;
    animation-duration: 4000ms;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
}
@-ms-keyframes spin {
    from { -ms-transform: rotate(0deg); }
    to { -ms-transform: rotate(360deg); }
}
@-moz-keyframes spin {
    from { -moz-transform: rotate(0deg); }
    to { -moz-transform: rotate(360deg); }
}
@-webkit-keyframes spin {
    from { -webkit-transform: rotate(0deg); }
    to { -webkit-transform: rotate(360deg); }
}
@keyframes spin {
    from {
        transform:rotate(0deg);
    }
    to {
        transform:rotate(360deg);
    }
}

#action {
  background: <?php echo $couleur_principale; ?> url(/../img/evenements.png) no-repeat;
  background-position: 50% 10px;
  background-repeat: no-repeat no-repeat;
  margin: -15px 6px 0 12px;
  padding: 25px 10px;
}

#action, #action a {
  color: white;
}

#action a {
  font-weight: bold;
}

#action h3 {
  margin: 0;
  padding: 0;
  font-size: 12px;
}

#action img {
  float: left;
  margin: 2px 5px 0 0;
  border: 1px solid white;
}

#action h3 {
  position: relative;
}

#acces {
  text-align: center;
}

#acces-reserve {
  display: block;
  width: 108px;
  height: 26px;
  text-indent: -9999em;
  overflow: hidden;
  background: transparent url(/../img/acces-reserve.gif) no-repeat;
  margin: 10px 10px 10px 100px;
}

#sms {
  text-decoration: none;
  display: block;
  overflow: hidden;
  width: 170px;
  border-right: 6px #707173 solid;
  background: white url(/../img/cd-eleveur.gif) no-repeat;
  background-position: 5px center;
  margin: 25px 0 5px 5px;
  padding: 5px 5px 5px 40px;
  color: black;
  text-transform: uppercase;
  font-weight: bold;
  margin-left: 40px;
  text-align: left;
}

#sms:hover {
  text-decoration: underline;
}

#sms strong {
  color: <?php echo $couleur_principale; ?>;
}

#credits {
	font-style:italic;
	font-size:.8em;
	text-align:center;
}
.mce-tinymce .mce-container .mce-panel {
		border:none !important;
}
.produits {
	display: block;
	padding: 0!important;
    margin: 0 0%;
    width: 100%;
}

ul.produits {
    padding: 0;
    margin: 0 auto !important;
    overflow: hidden;
}

ul.produits li {
    display: inline-block;
    height: 200px;
    overflow: hidden;
    padding: 0;
    float: left;
    position: relative;
}

#colonne ul.produits li a {
	border-bottom-style:solid !important;   
	border-bottom-width:2px !important;   
	border-bottom-color:#F5F4F1 !important;   
}
ul.produits li a.thumbnail {
	background-repeat: no-repeat;
	background-size: cover;
    background-color: #fff; 
	border: 2px solid #F5F4F1 ; 
	border-bottom: 2px solid #F5F4F1 ; 
    border-radius: 0 25px 0 25px;
    -webkit-border-radius: 0 25px 0 25px;
    -moz-border-radius: 0 25px 0 25px;
    background-position: 50% 50%;
	display: block; 
    box-sizing: border-box;
	transition: opacity 0.3s;
	-webkit-transition: opacity 0.3s;
	-moz-transition: opacity 0.3s;
	z-index: 9;
    width: 100%;
    height: 100%;
}

ul.produits li a.thumbnail h4 {
    position: absolute;
    top:0px;
    left: 0px;
    padding: 8px 10px;
    font-weight: bold;
    text-transform: uppercase;
    background-color: rgba(243, 242, 238, 0.8);
    color: <?php echo $couleur_secondaire; ?>;
    font-size: 12px;
    margin: 0;
	text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
}

ul.produits li a.thumbnail .description {
    padding: 0;
    position: absolute;
    height: 0;
    bottom: 16px;
    width: 100%;
    box-sizing: inherit;
    opacity: 0;
    transition: all 0.3s ease;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    color: #6b6b6b;
	margin-left: -6px;
    background-color: rgba(255, 255, 255, 0.8);
        font-size: 18px;
    padding: 6px 2px 18px;
    margin-top: 0;
    line-height: 18px;
    box-sizing: inherit;
    text-align: center;
	/* border-left:1px solid <?php echo $couleur_secondaire; ?>;
	border-right:1px solid <?php echo $couleur_secondaire; ?>;
	border-bottom:1px solid <?php echo $couleur_secondaire; ?>;
    border-radius: 0 0 0 25px;
    -moz-border-radius: 0 0 0 25px;
    -webkit-border-radius: 0 0 0 25px; */
}

ul.produits li a.thumbnail .active-arrow {
    width: 0;
    height: 0;
    border-left: 25px solid transparent;
    border-right: 25px solid transparent; 
    border-bottom: 25px solid <?php echo $couleur_principale; ?>;
    bottom: 2px;
    z-index: 99;
    transition: all 0.3s ease;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    position: absolute;
    left: 0;
    right: 0;
    margin: 0 auto;
}

ul.produits li a.thumbnail:hover .description {
	height: 50px;
	opacity: 1;
}

ul.produits li.content { 
	display: none; 
	background: none;
    list-style: none; 
    border: 2px dotted <?php echo $couleur_principale; ?>;
    margin-top: -3px !important;
	margin-bottom: 2% !important;
	float: left;
	height: 100%;
	position: relative;
	padding-bottom: 0 !important;
	
   background-color: rgba(255, 255, 255, 0.8);
	/* box-shadow: 0px 0px 6px #c4c4c4;
	-webkit-box-shadow: 0px 0px 6px #c4c4c4;
	-moz-box-shadow: 0px 0px 6px #c4c4c4; */
}

ul.produits li.content h3 {
    display: inline-block;
}

ul.produits li.content .close {
    position: absolute;
    right: 0px !important;
    top: 7px !important;
	font-size: 2em;
    color: #555;
    cursor: pointer;
	border:none;
    /* font-weight: normal;
    font-family: -webkit-pictograph;
	font-size: 3em;
    line-height: .7em; */
	background-color:#f3f2ee;
}

ul.produits li.content .close:hover {
    opacity: 0.7;
}

ul.produits li.content .media {
    display: inline-block;
    float: left;
	
    margin-top: 0px;
    margin-right: 30px;
    width: 30%;
    min-height: 250px;
}

.media {

    background-color: white !important;
    background-size: cover !important;
    background-position: 50% 50% !important;
	background-repeat:no-repeat !important;
	    max-width: 30% !important;
    padding: 0px !important;
}

ul.produits li.content .link a {
	margin: 3.5% 5% 3.5% 2% !important;
	float: right !important;
}

ul.produits li.content .media img {
    max-width: 100%;
	
  box-shadow: 0px 0px 0px #c4c4c4 !important;
  -webkit-box-shadow: 0px 0px 0px #c4c4c4 !important;
  -moz-box-shadow: 0px 0px 0px #c4c4c4 !important;
}
ul.produits li.content h2 {
	margin-top: 20px !important;
	width: 90%;
	margin-left: 2%;
    border-bottom: none;
}
#colonne .content p { 
    margin-left: 15px;
}
@media (min-width: 800px) { 
/* 	ul.produits .media {
		 
		display: block !important;
	}  */
    ul.produits li {
		width: 32% !important;
		margin: 0 0.5% !important;
		padding: 0 0 2% 0 !important;
    }
	ul.produits li.content {  
		width: 98% !important;
	} 
	#site-nom {
		display: none !important;
		font-size:0px;
	}
}

@media (max-width: 800px)  {
 	
	.dropdown-menu {
			background-color:<?php echo $couleur_principale; ?>;
	}
	ul.produits li {
		width: 49%  !important;
		margin:0 0.5% !important;
		padding: 0 0 2% 0 !important;
	}
	ul.produits li a.thumbnail .description { 
		bottom: 11px;
	}
	.media iframe{
		width: 100%;
	}  
	ul.produits li.content {  
		width: 98% !important;
	}
	ul.produits li.content .media { 
	}
	#pied {
		display:none;
	}
		
	#site-nom {
		display: none;
		cursor: pointer;
		position: fixed;
		width: 95%;
		height: 0;
		top: 15px;
		font-variant: capitalize; 
		text-align: center !important; 
		font-size: 20px;
		color: white;
		line-height: 1em;
		z-index: 0; 
	}
	#site-nom a {
		color: white !important;
		-webkit-transition: 0.2s ease;
		-moz-transition: 0.2s ease;
		-o-transition: 0.2s ease;
		transition: 0.2s ease;
		/* text-shadow: 1px 1px 0px #5a5a5a; */
	}
	#site-nom:hover {
		-ms-filter: "alpha(opacity=100)";
		filter: alpha(opacity=100);
		opacity: 1;
		/* text-shadow: 1px 1px 0px #5a5a5a; */
		-webkit-transition: 0.2s ease;
		-moz-transition: 0.2s ease;
		-o-transition: 0.2s ease;
		transition: 0.2s ease;
	}
	#back-to-top {
		border-left:none;
	}
}
 @media (max-width: 550px) {
	ul.produits li {
		width: 99% !important;
		margin: 0 0.5% !important;
		padding: 0 0 2% 0 !important;
	} 
	ul.produits li.content {  
		width: 98% !important;
	} 
	ul.produits li a.thumbnail .description { 
		bottom: 7px;
	}
}
  
ul.produits a{ 
	border-bottom: 2px solid <?php echo $couleur_principale; ?> ; 
}
ul.produits li a.active, #colonne ul.produits li a.thumbnail.active  {
	border: 2px dotted <?php echo $couleur_principale; ?> ; 
	border-bottom-style:dotted !important ; 
}
.portfolio-content {
    display: none;
}
.encart-site, .encart, .middle {
  width: 98%;
  border: 0px solid #cfcfcf;
  padding: 1%;
  margin: 0 0 2%;
}

.encart-site h2 {
  margin: 0.5em 0 0.5em 0;
}

.encart {
  background-color: #f5f5f5;
}

.encart-site {
  background-color: #f5f5f5;
}

.popover.id1:hover > p#id1 {
  background-color: red;
}

.important a {
  color: white;
  float: right;
}

.important {
  background-color: <?php echo $couleur_principale; ?>;
  color: white;
  float: left;
    /* margin-right: 6px; */
    /* margin-top: 50px; */
  padding: 10px;
    /* width: 223px; */;
}

.important h2 {
  text-transform: uppercase;
  font-weight: bold;
  font-size: 14px;
  margin: 0;
  padding: 0;
}

.text-left {
  text-align: left;
}

.text-right {
  text-align: right;
}

.text-center {
  text-align: center;
}
/* table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
.table {
    width: 100% !important;
    max-width: 100% !important;
    margin: 3% auto !important;
}
th, td {
    padding: 15px;
}
th {
    text-align: left;
} */

tr.cellules td {
  font-size: 0.8em !important;
  font-style: italic;
}

tr td.cellules {
  font-size: 0.8em !important;
  font-weight: bold !important;
  font-style: italic;
  border-right: 1px solid #e7e7e7 !important;
}

p.cellules {
  font-size: 0.8em !important;
  font-style: italic;
  text-align: center;
}

#clear {
  display: inline-block;
  width: 100%;
  height: 1px;
  padding: 0;
  margin: 0;
}

#footer {
/* height:345px;
background: white url(/../img/bandeau-bas.jpg) no-repeat;
background-position: bottom; */
  position: fixed;
  display: block;
  bottom: 0;
  right: 0;
  box-shadow: 0 0px 7px rgba(0, 0, 0, .3);
  -webkit-box-shadow: 0 0px 7px rgba(0, 0, 0, .3);
  -moz-box-shadow: 0 0px 7px rgba(0, 0, 0, .3);
  z-index: 999;
}

#pied, #pied a {
  color: white;
  text-decoration: none;
}

#pied a:hover {
  text-decoration: none;
}

#pied {
  font-family: 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;
  clear: both;
  padding: .5em 3em .5em 1em;
  font-weight: bold!important;
  font-size: 1.25em;
  text-align: center;
/* margin-top:320px; */
/* position:absolute; */
/* height: 22px; */
/* width: 760px; */
/* margin-left: 240px; */
  background-color: <?php echo $couleur_principale; ?>;
  color: white;
  text-decoration: none;
}
#pied:hover  {
  background-color: <?php echo $couleur_secondaire; ?>;
}
.navbar-nav > li {
  font-weight: bold;
  font-size: 1.3em;
  font-variant: small-caps;
  font-family: 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif !important;
}

.dropdown-menu > li > a {
  font-size: 1.175em;
  font-variant: normal;
  font-weight: normal;
  line-height: 1.42857143;
}
/* #pied span#contact-email, #pied span.telephone {
font-size:  ;
margin-right: 20px;
} */
/* #pied span#contact-email {
text-transform: uppercase;
padding-left: 20px;
background: transparent url(/../img/lettre-petit-rouge.gif) no-repeat;
background-position: 0 2px;
}
#pied span.telephone {
padding-left: 20px;
background: transparent url(/../img/telephone-petit-rouge.gif) no-repeat;
background-position: 0 3px;
} */
address {
  font-style: normal;
  margin-bottom: 1em;
}

#zone_production {
  border: none;
}

.popup {
/*width:215px;*/
  max-width: 200px;
  width: expression(this.scrollWidth > 200? 2 : true);
  background-color: white;
  border: 1px gray solid;
  padding: 5px;
}

#pied a.gi {
  color: #F18F10;
  text-decoration: none;
  font-size: 10px;
}

.images {
  float: left;
  margin-right: 10px;
}

.images img {
  padding: 2px;
  border: 1px solid gray;
}
/* #colonne h3, ul.liste2 li{
padding-top:1px;
padding-left:13px;
background:transparent url(/../img/fleche.gif) no-repeat;
background-position:0 3px;
margin-bottom:0;
} */
table.recrutement {
  text-align: center;
  width: 100%;
  border: 1px solid gray;
  border-collapse: collapse;
  margin-bottom: 2em;
}

table.recrutement  td {
  border: 1px solid gray;
}
th {
    text-align: left;
    font-size: 1.4em;
}
.alert {
    /* text-align: center; */
}

.phpdigHighlight {
  font-weight: bold;
}

ul#zoom {
  list-style-type: none;
  margin: 0;
  padding: 0;
  position: absolute;
  top: 0;
  margin: 210px 0 0 660px;
}

ul#zoom li {
  float: left;
}

ul#zoom  a {
  text-indent: -9999em;
  overflow: hidden;
  width: 23px;
  height: 21px;
  display: block;
  background-color: transparent;
}

a#txt-pet {
  background-image: url(/../img/txt-pet.gif);
}

a#txt-grd {
  margin-left: 5px;
  background-image: url(/../img/txt-grd.gif);
}

a#env {
  margin-left: 5px;
  background-image: url(/../img/env.gif);
}

#magazine {
  text-align: center;
  background-color: white;
  width: 100px;
  padding: 5px;
  float: right;
  clear: both;
}

#navigation a#extranet, #navigation a:hover#extranet {
  color: #CCC;
  text-decoration: none;
}

/************** COMMUN *******************/
a.pdf, a.doc, a.odt, a.xls, a.ods, a.document {
  padding-left: 32px;
  height: 32px;
  display: block;
  vertical-align: middle;
  padding-top: 8px;
}

ul.list_file li {
  background-image: none;
}

a.pdf {
  background: transparent url(/../img/icones/pdf.png) no-repeat;
}

a.doc, a.odt {
  background: transparent url(/../img/icones/document.png) no-repeat;
}

a.xls, a.ods {
  background: transparent url(/../img/icones/spreadsheet.png) no-repeat;
}

a.document {
  background: transparent url(/../img/icones/default.png) no-repeat;
}


thead {
  background-color: <?php echo $couleur_principale; ?>;
  color: white;
  text-transform: uppercase;
  border: 0px !important;
    font-family: "Cityof", 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;
  text-align: center;
  font-size: .8em;
    white-space: nowrap;
}
 
/* 
Make the Facebook Like box responsive (fluid width)
https://developers.facebook.com/docs/reference/plugins/like-box/ 
*/

/* 
This element holds injected scripts inside iframes that in 
some cases may stretch layouts. So, we're just hiding it. 
*/

#fb-root {
    display: none;
}

/* To fill the container and nothing else */

.fb_iframe_widget, .fb_iframe_widget span, .fb_iframe_widget span iframe[style] {
    max-width: 100% !important;
	margin-left:auto!important;
	margin-right:auto!important;
}

/************** FORMS *******************/

 .mce-panel  { 
    border-left: 1px solid #F0F0F0!important;
    border-right: 1px solid #F0F0F0!important;
    border-top: 0px solid #e3e3e3!important;
    border-bottom: 0px solid #e3e3e3!important;
    background-color: #F0F0F0;!important;
    border-radius: 4px!important;
}

form {
 width: 100%;
    margin: 0  ;
}
form label { 
    display: block;
    width: auto;
    font-size: 1.2em;
    margin: 0px 0 10px;
    font-weight: bold;
    font-variant: small-caps;
  }

form p {
  clear: left;
}

form fieldset {
  border: none;
}
/* form input, form select {
    font-size:11px;
	width:230px !important;
} */

.btn-primary, .btn-success, .btn-danger, .btn-info, .btn-warning {
    color: #ffffff !important;
}

ul.error li.first, form .required {
  color: <?php echo $couleur_principale; ?>;
  list-style-image: none;
  list-style-type: none;
  background-image: none;
  padding: 0;
}

ul.error li {
  color: <?php echo $couleur_principale; ?>;
  margin: 0;
  padding: 0 0 0 5px;
  list-style-image: none;
  list-style-type: none;
  background-image: none;
}

form p {
  margin: 0px 0;
  padding: 0;
}

label,
input,
button,
select,
textarea {
  font-size: 14px;
  font-weight: normal;
  line-height: 20px;
}

input,
button,
select,
textarea {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}

label {
  display: block;
  margin-bottom: 5px;
}

select,
textarea,
input[type="text"],
input[type="password"],
input[type="datetime"],
input[type="datetime-local"],
input[type="date"],
input[type="month"],
input[type="time"],
input[type="week"],
input[type="number"],
input[type="email"],
input[type="url"],
input[type="search"],
input[type="tel"],
input[type="color"],
.uneditable-input {
  display: inline-block;
  height: 26px;
  width:70%;
    max-width: 320px;
  padding: 4px 6px;
  margin-bottom: 0px;
  font-size: 14px;
  line-height: 20px;
  color: #555555;
  vertical-align: middle;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
}

input, 
.uneditable-input {
  /* width: 47%;   */
}

textarea {
  height: auto;
  width: 96.5%;
}

textarea,
input[type="text"],
input[type="password"],
input[type="datetime"],
input[type="datetime-local"],
input[type="date"],
input[type="month"],
input[type="time"],
input[type="week"],
input[type="number"],
input[type="email"],
input[type="url"],
input[type="search"],
input[type="tel"],
input[type="color"],
.uneditable-input {
  background-color: #ffffff;
  border: 1px solid #cccccc;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -webkit-transition: border linear 0.2s, box-shadow linear 0.2s;
  -moz-transition: border linear 0.2s, box-shadow linear 0.2s;
  -o-transition: border linear 0.2s, box-shadow linear 0.2s;
  transition: border linear 0.2s, box-shadow linear 0.2s;
}

textarea:focus,
input[type="text"]:focus,
input[type="password"]:focus,
input[type="datetime"]:focus,
input[type="datetime-local"]:focus,
input[type="date"]:focus,
input[type="month"]:focus,
input[type="time"]:focus,
input[type="week"]:focus,
input[type="number"]:focus,
input[type="email"]:focus,
input[type="url"]:focus,
input[type="search"]:focus,
input[type="tel"]:focus,
input[type="color"]:focus,
.uneditable-input:focus {
  border-color: rgba(82, 168, 236, 0.8);
  outline: 0;
  outline: thin dotted \9;
  /* IE6-9 */
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
}

input[type="radio"],
input[type="checkbox"] {
  margin: 4px 0 0;
  margin-top: 1px \9;
  *margin-top: 0;
  line-height: normal;
}

input[type="file"],
input[type="image"],
input[type="submit"],
input[type="reset"],
input[type="button"],
input[type="radio"],
input[type="checkbox"] {
  width: auto;
}

select,
input[type="file"] {
  height: 36px;
  /* In IE7, the height of the select element cannot be changed by height, only font-size */
  *margin-top: 4px;
  /* For IE7, add top margin to align select with labels */
  line-height: 30px;
}

select { 
  width:80%;
  background-color: #ffffff;
  border: 1px solid #cccccc;
}

select[multiple],
select[size] {
  height: auto;
}

select:focus,
input[type="file"]:focus,
input[type="radio"]:focus,
input[type="checkbox"]:focus {
  outline: thin dotted #333;
  outline: 5px auto -webkit-focus-ring-color;
  outline-offset: -2px;
}

.uneditable-input,
.uneditable-textarea {
  color: #999999;
  cursor: not-allowed;
  background-color: #fcfcfc;
  border-color: #cccccc;
  -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.025);
  -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.025);
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.025);
}

.uneditable-input {
  overflow: hidden;
  white-space: nowrap;
}

.uneditable-textarea {
  width: auto;
  height: auto;
}

input:-moz-placeholder,
textarea:-moz-placeholder {
  color: #999999;
}

input:-ms-input-placeholder,
textarea:-ms-input-placeholder {
  color: #999999;
}

input::-webkit-input-placeholder,
textarea::-webkit-input-placeholder {
  color: #999999;
}

.radio,
.checkbox {
  min-height: 20px;
  padding-left: 20px;
}

.radio input[type="radio"],
.checkbox input[type="checkbox"] {
  float: left;
  margin-left: -20px;
}

.controls > .radio:first-child,
.controls > .checkbox:first-child {
  padding-top: 5px;
}

.radio.inline,
.checkbox.inline {
  display: inline-block;
  padding-top: 5px;
  margin-bottom: 0;
  vertical-align: middle;
}

.radio.inline + .radio.inline,
.checkbox.inline + .checkbox.inline {
  margin-left: 10px;
}

.input-mini {
  width: 60px;
}

.input-small {
  width: 90px;
}

.input-medium {
  width: 150px;
}

.input-large {
  width: 210px;
}

.input-xlarge {
  width: 270px;
}

.input-xxlarge {
  width: 530px;
}

input[class*="span"],
select[class*="span"],
textarea[class*="span"],
.uneditable-input[class*="span"],
.row-fluid input[class*="span"],
.row-fluid select[class*="span"],
.row-fluid textarea[class*="span"],
.row-fluid .uneditable-input[class*="span"] {
  float: none;
  margin-left: 0;
}

.input-append input[class*="span"],
.input-append .uneditable-input[class*="span"],
.input-prepend input[class*="span"],
.input-prepend .uneditable-input[class*="span"],
.row-fluid input[class*="span"],
.row-fluid select[class*="span"],
.row-fluid textarea[class*="span"],
.row-fluid .uneditable-input[class*="span"],
.row-fluid .input-prepend [class*="span"],
.row-fluid .input-append [class*="span"] {
  display: inline-block;
}

input,
textarea,
.uneditable-input {
  margin-left: 0;
}

.controls-row [class*="span"] + [class*="span"] {
  margin-left: 20px;
}

input.span12,
textarea.span12,
.uneditable-input.span12 {
  width: 926px;
}

input.span11,
textarea.span11,
.uneditable-input.span11 {
  width: 846px;
}

input.span10,
textarea.span10,
.uneditable-input.span10 {
  width: 766px;
}

input.span9,
textarea.span9,
.uneditable-input.span9 {
  width: 686px;
}

input.span8,
textarea.span8,
.uneditable-input.span8 {
  width: 606px;
}

input.span7,
textarea.span7,
.uneditable-input.span7 {
  width: 526px;
}

input.span6,
textarea.span6,
.uneditable-input.span6 {
  width: 446px;
}

input.span5,
textarea.span5,
.uneditable-input.span5 {
  width: 366px;
}

input.span4,
textarea.span4,
.uneditable-input.span4 {
  width: 286px;
}

input.span3,
textarea.span3,
.uneditable-input.span3 {
  width: 206px;
}

input.span2,
textarea.span2,
.uneditable-input.span2 {
  width: 126px;
}

input.span1,
textarea.span1,
.uneditable-input.span1 {
  width: 46px;
}

.controls-row {
  *zoom: 1;
}

.controls-row:before,
.controls-row:after {
  display: table;
  line-height: 0;
  content: "";
}

.controls-row:after {
  clear: both;
}

.controls-row [class*="span"],
.row-fluid .controls-row [class*="span"] {
  float: left;
}

.controls-row .checkbox[class*="span"],
.controls-row .radio[class*="span"] {
  padding-top: 5px;
}

input[disabled],
select[disabled],
textarea[disabled],
input[readonly],
select[readonly],
textarea[readonly] {
  width:60%;
  cursor: not-allowed;
  background-color: #f3f2ee;
}

input[type="radio"][disabled],
input[type="checkbox"][disabled],
input[type="radio"][readonly],
input[type="checkbox"][readonly] {
  background-color: transparent;
}

.control-group.warning .control-label,
.control-group.warning .help-block,
.control-group.warning .help-inline {
  color: #c09853;
}

.control-group.warning .checkbox,
.control-group.warning .radio,
.control-group.warning input,
.control-group.warning select,
.control-group.warning textarea {
  color: #c09853;
}

.control-group.warning input,
.control-group.warning select,
.control-group.warning textarea {
  border-color: #c09853;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.control-group.warning input:focus,
.control-group.warning select:focus,
.control-group.warning textarea:focus {
  border-color: #a47e3c;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #dbc59e;
  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #dbc59e;
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #dbc59e;
}

.control-group.warning .input-prepend .add-on,
.control-group.warning .input-append .add-on {
  color: #c09853;
  background-color: #fcf8e3;
  border-color: #c09853;
}

.control-group.error .control-label,
.control-group.error .help-block,
.control-group.error .help-inline {
  color: #b94a48;
}

.control-group.error .checkbox,
.control-group.error .radio,
.control-group.error input,
.control-group.error select,
.control-group.error textarea {
  color: #b94a48;
}

.control-group.error input,
.control-group.error select,
.control-group.error textarea {
  border-color: #b94a48;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.control-group.error input:focus,
.control-group.error select:focus,
.control-group.error textarea:focus {
  border-color: #953b39;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #d59392;
  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #d59392;
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #d59392;
}

.control-group.error .input-prepend .add-on,
.control-group.error .input-append .add-on {
  color: #b94a48;
  background-color: #f2dede;
  border-color: #b94a48;
}

.control-group.success .control-label,
.control-group.success .help-block,
.control-group.success .help-inline {
  color: #468847;
}

.control-group.success .checkbox,
.control-group.success .radio,
.control-group.success input,
.control-group.success select,
.control-group.success textarea {
  color: #468847;
}

.control-group.success input,
.control-group.success select,
.control-group.success textarea {
  border-color: #468847;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.control-group.success input:focus,
.control-group.success select:focus,
.control-group.success textarea:focus {
  border-color: #356635;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #7aba7b;
  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #7aba7b;
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #7aba7b;
}

.control-group.success .input-prepend .add-on,
.control-group.success .input-append .add-on {
  color: #468847;
  background-color: #dff0d8;
  border-color: #468847;
}

.control-group.info .control-label,
.control-group.info .help-block,
.control-group.info .help-inline {
  color: #3db1ff;
}

.control-group.info .checkbox,
.control-group.info .radio,
.control-group.info input,
.control-group.info select,
.control-group.info textarea {
  color: #3db1ff;
}

.control-group.info input,
.control-group.info select,
.control-group.info textarea {
  border-color: #3db1ff;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.control-group.info input:focus,
.control-group.info select:focus,
.control-group.info textarea:focus {
  border-color: #3db1ff;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #7ab5d3;
  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #7ab5d3;
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #7ab5d3;
}

.control-group.info .input-prepend .add-on,
.control-group.info .input-append .add-on {
  color: #3db1ff;
  background-color: #d9edf7;
  border-color: #3db1ff;
}

input:focus:invalid,
textarea:focus:invalid,
select:focus:invalid {
  color: #b94a48;
  border-color: #ee5f5b;
}

input:focus:invalid:focus,
textarea:focus:invalid:focus,
select:focus:invalid:focus {
  border-color: #e9322d;
  -webkit-box-shadow: 0 0 6px #f8b9b7;
  -moz-box-shadow: 0 0 6px #f8b9b7;
  box-shadow: 0 0 6px #f8b9b7;
}

.input-append .add-on,
.input-prepend .add-on,
.input-append .btn,
.input-prepend .btn,
.input-append .btn-group > .dropdown-toggle,
.input-prepend .btn-group > .dropdown-toggle {
  vertical-align: top;
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  border-radius: 0;
}

.input-append .active,
.input-prepend .active {
  background-color: #a9dba9;
  border-color: #46a546;
}

.input-prepend .add-on,
.input-prepend .btn {
  margin-right: -1px;
}

.input-prepend .add-on:first-child,
.input-prepend .btn:first-child {
  -webkit-border-radius: 4px 0 0 4px;
  -moz-border-radius: 4px 0 0 4px;
  border-radius: 4px 0 0 4px;
}

.input-append input,
.input-append select,
.input-append .uneditable-input {
  -webkit-border-radius: 4px 0 0 4px;
  -moz-border-radius: 4px 0 0 4px;
  border-radius: 4px 0 0 4px;
}

.input-append input + .btn-group .btn:last-child,
.input-append select + .btn-group .btn:last-child,
.input-append .uneditable-input + .btn-group .btn:last-child {
  -webkit-border-radius: 0 4px 4px 0;
  -moz-border-radius: 0 4px 4px 0;
  border-radius: 0 4px 4px 0;
}

.input-append .add-on,
.input-append .btn,
.input-append .btn-group {
  margin-left: -1px;
}

.input-append .add-on:last-child,
.input-append .btn:last-child,
.input-append .btn-group:last-child > .dropdown-toggle {
  -webkit-border-radius: 0 4px 4px 0;
  -moz-border-radius: 0 4px 4px 0;
  border-radius: 0 4px 4px 0;
}

.input-prepend.input-append input,
.input-prepend.input-append select,
.input-prepend.input-append .uneditable-input {
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  border-radius: 0;
}

.input-prepend.input-append input + .btn-group .btn,
.input-prepend.input-append select + .btn-group .btn,
.input-prepend.input-append .uneditable-input + .btn-group .btn {
  -webkit-border-radius: 0 4px 4px 0;
  -moz-border-radius: 0 4px 4px 0;
  border-radius: 0 4px 4px 0;
}

.input-prepend.input-append .add-on:first-child,
.input-prepend.input-append .btn:first-child {
  margin-right: -1px;
  -webkit-border-radius: 4px 0 0 4px;
  -moz-border-radius: 4px 0 0 4px;
  border-radius: 4px 0 0 4px;
}

.input-prepend.input-append .add-on:last-child,
.input-prepend.input-append .btn:last-child {
  margin-left: -1px;
  -webkit-border-radius: 0 4px 4px 0;
  -moz-border-radius: 0 4px 4px 0;
  border-radius: 0 4px 4px 0;
}

.input-prepend.input-append .btn-group:first-child {
  margin-left: 0;
}

input.search-query {
  padding-right: 14px;
  padding-right: 4px \9;
  padding-left: 14px;
  padding-left: 4px \9;
  /* IE7-8 doesn't have border-radius, so don't indent the padding */
  margin-bottom: 0;
  -webkit-border-radius: 15px;
  -moz-border-radius: 15px;
  border-radius: 15px;
}

/* Allow for input prepend/append in search forms */

.form-search .input-append .search-query,
.form-search .input-prepend .search-query {
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  border-radius: 0;
}

.form-search .input-append .search-query {
  -webkit-border-radius: 14px 0 0 14px;
  -moz-border-radius: 14px 0 0 14px;
  border-radius: 14px 0 0 14px;
}

.form-search .input-append .btn {
  -webkit-border-radius: 0 14px 14px 0;
  -moz-border-radius: 0 14px 14px 0;
  border-radius: 0 14px 14px 0;
}

.form-search .input-prepend .search-query {
  -webkit-border-radius: 0 14px 14px 0;
  -moz-border-radius: 0 14px 14px 0;
  border-radius: 0 14px 14px 0;
}

.form-search .input-prepend .btn {
  -webkit-border-radius: 14px 0 0 14px;
  -moz-border-radius: 14px 0 0 14px;
  border-radius: 14px 0 0 14px;
}

.form-search input,
.form-inline input,
.form-horizontal input,
.form-search textarea,
.form-inline textarea,
.form-horizontal textarea,
.form-search select,
.form-inline select,
.form-horizontal select,
.form-search .help-inline,
.form-inline .help-inline,
.form-horizontal .help-inline,
.form-search .uneditable-input,
.form-inline .uneditable-input,
.form-horizontal .uneditable-input,
.form-search .input-prepend,
.form-inline .input-prepend,
.form-horizontal .input-prepend,
.form-search .input-append,
.form-inline .input-append,
.form-horizontal .input-append {
  display: inline-block;
  *display: inline;
  margin-bottom: 0;
  vertical-align: middle;
  *zoom: 1;
}

.form-search .hide,
.form-inline .hide,
.form-horizontal .hide {
  display: none;
}

.form-search label,
.form-inline label,
.form-search .btn-group,
.form-inline .btn-group {
  display: inline-block;
}

.form-search .input-append,
.form-inline .input-append,
.form-search .input-prepend,
.form-inline .input-prepend {
  margin-bottom: 0;
}

.form-search .radio,
.form-search .checkbox,
.form-inline .radio,
.form-inline .checkbox {
  padding-left: 0;
  margin-bottom: 0;
  vertical-align: middle;
}

.form-search .radio input[type="radio"],
.form-search .checkbox input[type="checkbox"],
.form-inline .radio input[type="radio"],
.form-inline .checkbox input[type="checkbox"] {
  float: left;
  margin-right: 3px;
  margin-left: 0;
}

.btn {
  display: inline-block;
  *display: inline;
  padding: 8px 12px;
  margin-bottom: 0;
  *margin-left: .3em;
  font-size: 14px;
  min-width: 14px;
  line-height: 20px;
  color: #333333;
  text-align: center;
  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
  vertical-align: middle;
  cursor: pointer;
  
    border: none;
  background-color: #f5f5f5;
  *background-color: #e6e6e6;
 /*  background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
  background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
  background-repeat: repeat-x;
  border: 1px solid #cccccc;
  *border: 0;
  border-color: #e6e6e6 #e6e6e6 #bfbfbf;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  border-bottom-color: #b3b3b3; */
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  /* filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); */
  *zoom: 1;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
}

.btn:hover,
.btn:focus,
.btn:active,
.btn.active,
.btn.disabled,
.btn[disabled] {
  color: #333333;
  background-color: #e6e6e6;
  *background-color: #d9d9d9;
}

.btn:active,
.btn.active {
  background-color: #cccccc \9;
}

.btn:first-child {
  *margin-left: 0;
}

.btn:hover,
.btn:focus {
  color: #333333;
  text-decoration: none;
  background-position: 0 -15px;
  -webkit-transition: background-position 0.1s linear;
  -moz-transition: background-position 0.1s linear;
  -o-transition: background-position 0.1s linear;
  transition: background-position 0.1s linear;
}

.btn:focus {
  outline: thin dotted #333;
  outline: 5px auto -webkit-focus-ring-color;
  outline-offset: -2px;
}

.btn.active,
.btn:active {
  background-image: none;
  outline: 0;
  -webkit-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
  -moz-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
}

.btn.disabled,
.btn[disabled] {
  cursor: default;
  background-image: none;
  opacity: 0.65;
  filter: alpha(opacity=65);
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
}

.btn-large {
  padding: 12px 20px;
  font-size: 17.5px;
/*   -webkit-border-radius: 6px;
  -moz-border-radius: 6px;
  border-radius: 6px; */
}

.btn-large [class^="icon-"],
.btn-large [class*=" icon-"] {
  margin-top: 4px;
}

.btn-small {
  padding: 2px 10px;
  font-size: 11.9px;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
}

.btn-small [class^="icon-"],
.btn-small [class*=" icon-"] {
  margin-top: 0;
}

.btn-mini [class^="icon-"],
.btn-mini [class*=" icon-"] {
  margin-top: -1px;
}

.btn-mini {
  padding: 0 6px;
  font-size: 10.5px;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
}

.btn-block {
  display: block;
      width: 100%;
    margin: 0  ;
  padding-right: 0;
  padding-left: 0;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.btn-block + .btn-block {
  margin-top: 5px;
}

input[type="submit"].btn-block,
input[type="reset"].btn-block,
input[type="button"].btn-block {
  width: 100%;
}

.btn-primary.active,
.btn-warning.active,
.btn-danger.active,
.btn-success.active,
.btn-info.active,
.btn-inverse.active {
  color: rgba(255, 255, 255, 0.75);
}

.btn-primary {
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: #006dcc;
  *background-color: #0044cc;
  /* background-image: -moz-linear-gradient(top, #0088cc, #0044cc);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
  background-image: -webkit-linear-gradient(top, #0088cc, #0044cc);
  background-image: -o-linear-gradient(top, #0088cc, #0044cc);
  background-image: linear-gradient(to bottom, #0088cc, #0044cc);
  background-repeat: repeat-x;
  border-color: #0044cc #0044cc #002a80;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc', endColorstr='#ff0044cc', GradientType=0); */
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
}

.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active,
.btn-primary.active,
.btn-primary.disabled,
.btn-primary[disabled] {
  color: #ffffff;
  background-color: #0044cc;
  *background-color: #003bb3;
}

.btn-primary:active,
.btn-primary.active {
  background-color: #003399 \9;
}

.btn-warning {
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: #faa732;
  *background-color: #f89406;
 /*  background-image: -moz-linear-gradient(top, #fbb450, #f89406);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fbb450), to(#f89406));
  background-image: -webkit-linear-gradient(top, #fbb450, #f89406);
  background-image: -o-linear-gradient(top, #fbb450, #f89406);
  background-image: linear-gradient(to bottom, #fbb450, #f89406);
  background-repeat: repeat-x;
  border-color: #f89406 #f89406 #ad6704;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fffbb450', endColorstr='#fff89406', GradientType=0);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); */
}

.btn-warning:hover,
.btn-warning:focus,
.btn-warning:active,
.btn-warning.active,
.btn-warning.disabled,
.btn-warning[disabled] {
  color: #ffffff;
  background-color: #f89406;
  *background-color: #df8505;
}

.btn-warning:active,
.btn-warning.active {
  background-color: #c67605 \9;
}

.btn-danger {
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: #da4f49;
  *background-color: #bd362f;
 /*  background-image: -moz-linear-gradient(top, #ee5f5b, #bd362f);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ee5f5b), to(#bd362f));
  background-image: -webkit-linear-gradient(top, #ee5f5b, #bd362f);
  background-image: -o-linear-gradient(top, #ee5f5b, #bd362f);
  background-image: linear-gradient(to bottom, #ee5f5b, #bd362f);
  background-repeat: repeat-x;
  border-color: #bd362f #bd362f #802420;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffee5f5b', endColorstr='#ffbd362f', GradientType=0);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); */
}

.btn-danger:hover,
.btn-danger:focus,
.btn-danger:active,
.btn-danger.active,
.btn-danger.disabled,
.btn-danger[disabled] {
  color: #ffffff;
  background-color: #bd362f;
  *background-color: #a9302a;
}

.btn-danger:active,
.btn-danger.active {
  background-color: #942a25 \9;
}

.btn-success {
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: #5bb75b;
  *background-color: #51a351;
 /*  background-image: -moz-linear-gradient(top, #62c462, #51a351);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#62c462), to(#51a351));
  background-image: -webkit-linear-gradient(top, #62c462, #51a351);
  background-image: -o-linear-gradient(top, #62c462, #51a351);
  background-image: linear-gradient(to bottom, #62c462, #51a351);
  background-repeat: repeat-x;
  border-color: #51a351 #51a351 #387038;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff62c462', endColorstr='#ff51a351', GradientType=0);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); */
}

.btn-success:hover,
.btn-success:focus,
.btn-success:active,
.btn-success.active,
.btn-success.disabled,
.btn-success[disabled] {
  color: #ffffff;
  background-color: #51a351;
  *background-color: #499249;
}

.btn-success:active,
.btn-success.active {
  background-color: #408140 \9;
}

a.btn-info, .btn-info {
  color: #ffffff !important;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: #3db1ff;
  *background-color: #3498DB;
 /*  background-image: -moz-linear-gradient(top, #3db1ff, #3498DB);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#3db1ff), to(#3498DB));
  background-image: -webkit-linear-gradient(top, #3db1ff, #3498DB);
  background-image: -o-linear-gradient(top, #3db1ff, #3498DB);
  background-image: linear-gradient(to bottom, #3db1ff, #3498DB);
  background-repeat: repeat-x;
  border-color: #3498DB #3498DB #1f6377;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff3db1ff', endColorstr='#ff3498DB', GradientType=0);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); */
}

.btn-info:hover,
.btn-info:focus,
.btn-info:active,
.btn-info.active,
.btn-info.disabled,
.btn-info[disabled] {
  color: #ffffff !important;
  background-color: #3498DB;
  *background-color: #2a85a0;
}

.btn-info:active,
.btn-info.active {
  background-color: #24748c \9;
}

.btn-inverse {
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: #363636;
  *background-color: #222222;
 /*  background-image: -moz-linear-gradient(top, #444444, #222222);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#444444), to(#222222));
  background-image: -webkit-linear-gradient(top, #444444, #222222);
  background-image: -o-linear-gradient(top, #444444, #222222);
  background-image: linear-gradient(to bottom, #444444, #222222);
  background-repeat: repeat-x;
  border-color: #222222 #222222 #000000;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff444444', endColorstr='#ff222222', GradientType=0);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); */
}

.btn-inverse:hover,
.btn-inverse:focus,
.btn-inverse:active,
.btn-inverse.active,
.btn-inverse.disabled,
.btn-inverse[disabled] {
  color: #ffffff;
  background-color: #222222;
  *background-color: #151515;
}

.btn-inverse:active,
.btn-inverse.active {
  background-color: #080808 \9;
}

button.btn,
input[type="submit"].btn {
  *padding-top: 3px;
  *padding-bottom: 3px;
}

button.btn::-moz-focus-inner,
input[type="submit"].btn::-moz-focus-inner {
  padding: 0;
  border: 0;
}

button.btn.btn-large,
input[type="submit"].btn.btn-large {
  *padding-top: 7px;
  *padding-bottom: 7px;
}

button.btn.btn-small,
input[type="submit"].btn.btn-small {
  *padding-top: 3px;
  *padding-bottom: 3px;
}

button.btn.btn-mini,
input[type="submit"].btn.btn-mini {
  *padding-top: 1px;
  *padding-bottom: 1px;
}
 
legend {
  display: inline-block;
  width: 100%;
  padding: 0;
  padding-bottom: .5em;
  margin-bottom: .5em;
  font-size: 1.2em;
  margin-top: 1.2em;
  line-height: inherit;
  color: #333;
  border: 0;
  border-bottom: 1px solid #e5e5e5;
}


.label,
.badge {
  font-size: 11.844px;
  font-weight: bold;
  line-height: 14px;
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  white-space: nowrap;
  vertical-align: baseline;
  background-color: #999999;
}

.label {
  padding: 1px 4px 2px;
  -webkit-border-radius: 3px;
     -moz-border-radius: 3px;
          border-radius: 3px;
}

.badge {
  padding: 1px 9px 2px;
  -webkit-border-radius: 9px;
     -moz-border-radius: 9px;
          border-radius: 9px;
}

a.label:hover,
a.badge:hover {
  color: #ffffff;
  text-decoration: none;
  cursor: pointer;
}

.label-important,
.badge-important {
  background-color: #b94a48;
}

.label-important[href],
.badge-important[href] {
  background-color: #953b39;
}

.label-warning,
.badge-warning {
  background-color: #f89406;
}

.label-warning[href],
.badge-warning[href] {
  background-color: #c67605;
}

.label-success,
.badge-success {
  background-color: #468847;
}

.label-success[href],
.badge-success[href] {
  background-color: #356635;
}

.label-info,
.badge-info {
  background-color: #3db1ff;
}

.label-info[href],
.badge-info[href] {
  background-color: #3db1ff;
}

.label-inverse,
.badge-inverse {
  background-color: #333333;
}

.label-inverse[href],
.badge-inverse[href] {
  background-color: #1a1a1a;
}

.btn .label,
.btn .badge {
  position: relative;
  top: -1px;
}

.btn-mini .label,
.btn-mini .badge {
  top: 0;
}

@-webkit-keyframes progress-bar-stripes {
  from {
    background-position: 40px 0;
  }
  to {
    background-position: 0 0;
  }
}

@-moz-keyframes progress-bar-stripes {
  from {
    background-position: 40px 0;
  }
  to {
    background-position: 0 0;
  }
}

@-ms-keyframes progress-bar-stripes {
  from {
    background-position: 40px 0;
  }
  to {
    background-position: 0 0;
  }
}

@-o-keyframes progress-bar-stripes {
  from {
    background-position: 0 0;
  }
  to {
    background-position: 40px 0;
  }
}

@keyframes progress-bar-stripes {
  from {
    background-position: 40px 0;
  }
  to {
    background-position: 0 0;
  }
}

.progress {
  height: 30px;
    line-height: 30px;
  margin-bottom: 20px;
  overflow: hidden;
  background-color: #f7f7f7;
  background-image: -moz-linear-gradient(top, #f5f5f5, #f9f9f9);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f5f5f5), to(#f9f9f9));
  background-image: -webkit-linear-gradient(top, #f5f5f5, #f9f9f9);
  background-image: -o-linear-gradient(top, #f5f5f5, #f9f9f9);
  background-image: linear-gradient(to bottom, #f5f5f5, #f9f9f9);
  background-repeat: repeat-x;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
  filter: progid:dximagetransform.microsoft.gradient(startColorstr='#fff5f5f5', endColorstr='#fff9f9f9', GradientType=0);
  -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
     -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
          box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
}
.progress-bar { 
    line-height: 30px;
}
.progress .bar {
  float: left;
  width: 0;
  height: 100%;
  
    line-height: 40px;
  font-size: 12px;
  color: #ffffff;
  text-align: center;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: #0e90d2;
  background-image: -moz-linear-gradient(top, #149bdf, #0480be);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#149bdf), to(#0480be));
  background-image: -webkit-linear-gradient(top, #149bdf, #0480be);
  background-image: -o-linear-gradient(top, #149bdf, #0480be);
  background-image: linear-gradient(to bottom, #149bdf, #0480be);
  background-repeat: repeat-x;
  filter: progid:dximagetransform.microsoft.gradient(startColorstr='#ff149bdf', endColorstr='#ff0480be', GradientType=0);
  -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15);
     -moz-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15);
          box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15);
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  -webkit-transition: width 0.6s ease;
     -moz-transition: width 0.6s ease;
       -o-transition: width 0.6s ease;
          transition: width 0.6s ease;
}

.progress .bar + .bar {
  -webkit-box-shadow: inset 1px 0 0 rgba(0, 0, 0, 0.15), inset 0 -1px 0 rgba(0, 0, 0, 0.15);
     -moz-box-shadow: inset 1px 0 0 rgba(0, 0, 0, 0.15), inset 0 -1px 0 rgba(0, 0, 0, 0.15);
          box-shadow: inset 1px 0 0 rgba(0, 0, 0, 0.15), inset 0 -1px 0 rgba(0, 0, 0, 0.15);
}

.progress-striped .bar {
  background-color: #149bdf;
  background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));
  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: -moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  -webkit-background-size: 40px 40px;
     -moz-background-size: 40px 40px;
       -o-background-size: 40px 40px;
          background-size: 40px 40px;
}

.progress.active .bar {
  -webkit-animation: progress-bar-stripes 2s linear infinite;
     -moz-animation: progress-bar-stripes 2s linear infinite;
      -ms-animation: progress-bar-stripes 2s linear infinite;
       -o-animation: progress-bar-stripes 2s linear infinite;
          animation: progress-bar-stripes 2s linear infinite;
}

.progress-danger .bar,
.progress .bar-danger {
  background-color: #dd514c;
  background-image: -moz-linear-gradient(top, #ee5f5b, #c43c35);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ee5f5b), to(#c43c35));
  background-image: -webkit-linear-gradient(top, #ee5f5b, #c43c35);
  background-image: -o-linear-gradient(top, #ee5f5b, #c43c35);
  background-image: linear-gradient(to bottom, #ee5f5b, #c43c35);
  background-repeat: repeat-x;
  filter: progid:dximagetransform.microsoft.gradient(startColorstr='#ffee5f5b', endColorstr='#ffc43c35', GradientType=0);
}

.progress-danger.progress-striped .bar,
.progress-striped .bar-danger {
  background-color: #ee5f5b;
  background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));
  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: -moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
}

.progress-success .bar,
.progress .bar-success {
  background-color: #5eb95e;
  background-image: -moz-linear-gradient(top, #62c462, #57a957);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#62c462), to(#57a957));
  background-image: -webkit-linear-gradient(top, #62c462, #57a957);
  background-image: -o-linear-gradient(top, #62c462, #57a957);
  background-image: linear-gradient(to bottom, #62c462, #57a957);
  background-repeat: repeat-x;
  filter: progid:dximagetransform.microsoft.gradient(startColorstr='#ff62c462', endColorstr='#ff57a957', GradientType=0);
}

.progress-success.progress-striped .bar,
.progress-striped .bar-success {
  background-color: #62c462;
  background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));
  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: -moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
}

.progress-info .bar,
.progress .bar-info {
  background-color: #4bb1cf;
  background-image: -moz-linear-gradient(top, #3db1ff, #339bb9);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#3db1ff), to(#339bb9));
  background-image: -webkit-linear-gradient(top, #3db1ff, #339bb9);
  background-image: -o-linear-gradient(top, #3db1ff, #339bb9);
  background-image: linear-gradient(to bottom, #3db1ff, #339bb9);
  background-repeat: repeat-x;
  filter: progid:dximagetransform.microsoft.gradient(startColorstr='#ff3db1ff', endColorstr='#ff339bb9', GradientType=0);
}

.progress-info.progress-striped .bar,
.progress-striped .bar-info {
  background-color: #3db1ff;
  background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));
  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: -moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
}

.progress-warning .bar,
.progress .bar-warning {
  background-color: #faa732;
  background-image: -moz-linear-gradient(top, #fbb450, #f89406);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fbb450), to(#f89406));
  background-image: -webkit-linear-gradient(top, #fbb450, #f89406);
  background-image: -o-linear-gradient(top, #fbb450, #f89406);
  background-image: linear-gradient(to bottom, #fbb450, #f89406);
  background-repeat: repeat-x;
  filter: progid:dximagetransform.microsoft.gradient(startColorstr='#fffbb450', endColorstr='#fff89406', GradientType=0);
}

.progress-warning.progress-striped .bar,
.progress-striped .bar-warning {
  background-color: #fbb450;
  background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));
  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: -moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
  background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
}
