<?php 		
	session_start() ;
	require('fonction.php') ;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
   <head>
       <title>Bienvenue sur mon site !</title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	   <link rel="stylesheet" media="screen" type="text/css" title="Design" href="design.css" />
   </head>
   <body>

		<div class='page'>
		
			<?php
				include ("codes_communs/en_tete.php") ; 
				include ("codes_communs/menu.php") ; 
			?>
			
			<div id="corps">
				<h1>Bienvenue sur le site de gestion<br />des données de SolidaTerray</h1>
				<p>C'est ici que seront bientot ecrites les news et autre.</p>
				<h4>Pourquoi ce site ?</h4>
				<p>Ce site n'est pas destiné a une usage grand public mais juste aux eleves et profs du college pour le permettre
				de connaitre en direct les resultats de le collecte pour la banque alimentaire.</p>
				<h4>Avancée du site :</h4>
				<p>Le site en est actuellement a sa phase de developpement et ne sera pas en version beta avant le mois de septembre <strong>(au moins)</strong>.</p>
			</div>
			
			<div id="pied_de_page">
			</div>
		</div>
			<?php include("codes_communs/pied_de_page.php") ; ?>
   </body>
</html>