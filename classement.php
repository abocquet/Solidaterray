<?php 	
	session_start() ;
	require('fonction.php') ;

	$bdd = connection() ;
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
				<?php
					if (isset($_GET['classement']) && !empty($_GET['classement']))
					{
						if (isset($_GET['classe']) && !empty($_GET['classe']))
						{
							if (isset($_GET['groupe']) && !empty($_GET['groupe']))
							{
								$req = $bdd->prepare('SELECT * FROM classe WHERE niveau = ? AND groupe = ?') ;
								$req->execute(array($_GET['classe'], $_GET['groupe'])) ;
											
								$donnees = $req->fetch() ;
								echo('<p>La classe de ' . $donnees['niveau'] . '<sup>èm</sup>' . $donnees['groupe'] . ' a appporté de la nouriture pour un poids
												total de ' . $donnees['poid'] . ' kg et ' . $donnees['point'] . ' points, qui se détail comme suit :</p>') ;
												
								$req->closeCursor() ;
											
								$req = $bdd->prepare('SELECT * FROM entrees WHERE niveau = ? AND groupe = ? ORDER BY date_ajout DESC LIMIT 0, 15') ;
								$req->execute(array($_GET['classe'], $_GET['groupe'])) ;
											
								while ($donnees = $req->fetch())
								{
									echo ('<p><dd>- entrée n°' . $donnees["id"] . ' pèse ' 
										.$donnees["poid"] . ' kg et rapporte ' .$donnees["point"]. ' points.</p>');
											}
											
									$req->closeCursor() ;
							}
							else
							{
								/*Affichage du classement du niveau selectionné*/
								$req = $bdd->prepare('SELECT * FROM classe WHERE niveau = ? ORDER BY total DESC');
								$req->execute(array($_GET['classe'])) ;
											
								echo ("<h1>Classement total :</h1><table> <tr> <th>Classe</th> <th>Poids</th> <th>Points</th> <th>Total</th></tr>") ;
								while($donnees = $req->fetch())
								{
									echo ('<tr> <td>' . $donnees['niveau'] . '<sup>èm</sup>' . $donnees['groupe'] . '</td> 
										<td>' . $donnees['poid'] . '</td> <td>' . $donnees['point'] . '</td><td>'. $donnees['total'] . '</td>') ;
								}
								echo ("</table>") ;
										
								$req->closeCursor() ;
							}
							}
						else
						{
							/*Affichage du classement général, par poids ou points*/
							switch($_GET['classement'])
							{
								case 1:
									echo(" <h1>Classement total :</h1> <table>") ;
									$req = $bdd->query('SELECT * FROM classe ORDER BY total DESC');
									break;
								case 2:
									echo("<h1>Classement par points :</h1><table> ") ;
									$req = $bdd->query('SELECT * FROM classe ORDER BY point DESC');
									break;
								case 3:
									echo("<h1>Classement par poids :</h1><table> ") ;
									$req = $bdd->query('SELECT * FROM classe ORDER BY poid DESC');
									break;
								default:
									echo("<h1>Probleme mon gars</h1>") ;
									break;
							}
							$i = 1;
							
							echo ("<table> <tr> <th>Rang</th><th>Classe</th> <th>Poids</th> <th>Points</th> <th>Total</th></tr>") ;
							while($donnees = $req->fetch())
							{
								echo ('<tr> <td>'. $i .'<td>' . $donnees['niveau'] . '<sup>èm</sup>' . $donnees['groupe'] . '</td> 
								<td>' . $donnees['poid'] . '</td> <td>' . $donnees['point'] . '</td><td>'. $donnees['total'] . '</td>') ;
								$i ++;
							}
							echo ("</table>") ;
						}			
							
					}
			
				?>
			</div>
			
				<div id="pied_de_page">
				</div>
		</div>
			<?php include("codes_communs/pied_de_page.php") ; ?>
   </body>
</html>