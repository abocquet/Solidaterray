<?php 		
	if (!isset($_SESSION['login']) && !isset($_SESSION['passwd']))
	{
		header('Location: index.php') ;
		return 0;
	}

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
				<h2>Bienvenue dans la partie membre.</h2>
				<p>Ici vous pourrez ajouter des entrées, en modifier et en supprimer. Vous pouvez toujours naviguer librement dans
				les autres parties du site.</p>
				
				<h4>Rappel :</h4>
				<p>Les produits frais ou à conserver au foid ne <strong>doivent pas</strong> être acceptés.</p>
				
			</div>
			
			<div id="pied_de_page">
			</div>
		</div>
			<?php include("codes_communs/pied_de_page.php") ; ?>
   </body>
</html>