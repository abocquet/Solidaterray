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
				<div class="formulaire">
						<?php
							if (isset($_SESSION['login']) && isset($_SESSION['passwd']))
							{
								if (isset($_SESSION['message']))
								{					
									echo '<div class=\'message\'>' . $_SESSION['message'] . '</div>' ;
									$_SESSION['message'] = '' ;
								}
								
								if(!isset($_GET['id']))
								{
									if($_SESSION['admin'] == 1)
									{
										$req = $bdd->query('SELECT * FROM entrees ORDER BY id DESC') ;
									}
									else
									{
										$req = $bdd->prepare('SELECT * FROM entrees WHERE id_ajout = ?  ORDER BY id DESC') ;
										$req->execute(array($_SESSION['id'])) ;
									}
									echo '<fieldset><legend>Modifier une entrée</legend>
										<table>
											<tr>
												<th>Classe</th> 
												<th>Poids</th>
												<th>Points</th>
												<th>Modifier</th>
												<th>Supprimer</th>
											</tr>' ;
										
										while($donnees = $req->fetch())
										{
											echo '<tr>
													<td>' . $donnees['niveau'] . '<sup>èm</sup>' . $donnees['groupe'] . '</td>
													<td>' . $donnees['poid'] . '</td>
													<td>' . $donnees['point'] . '</td>
													<td> <a class=\'centre\'href=\'modifier.php?id=' . $donnees['id'] . '\'><img src="images/modifier.png"></a></td>
													<td><a class=\'centre\' href=\'supprimer.php?id=' . $donnees['id'] . '\'><img src="images/supprimer.png"></a></td>
												</tr>' ;
										}
									
										
									echo '</table><br /> <br /></fieldset>' ;
									
								}
								else
								{
									$req = $bdd->prepare('SELECT * FROM entrees WHERE id = ?') ;
										$req->execute(array($_GET['id'])) ;
										
									if($donnees = $req->fetch())
									{
										$poids_kg = floor($donnees['poid']) ;
										$poids_g =  ($donnees['poid'] - $poids_kg) * 1000;
									?>
										<form method='post' action='action.php'>
										<fieldset>
										<legend>Modifier l'entrée n°<?php echo $donnees['id']?> </legend>
											<strong>Classe de <?php echo $donnees['niveau'] ; ?> <sup>ème</sup> <?php echo $donnees['groupe'] ; ?>  :</strong>
											<br /><br />
											Poids : <input type='text' name='poid_kg' id='poid_kg' value=<?php echo '\'' . $poids_kg . '\''?> autocomplete='off' onFocus="value=''"/> kg
											<input type='text' name='poid_g' id='poid_kg' value=<?php echo '\'' . $poids_g . '\''?> autocomplete='off' onFocus="value=''"/> g 
											<br /><br />
												Type : 
												<select name='type' id='type'>
												<optgroup label='--- Type ---' >
												<option value="poudres" <?php if($donnees['type'] == 1) { echo 'selected="selected"' ;}?>>Poudres (sel/sucre/farine/poivre …)</option>
												<option value="pondereux" <?php if($donnees['type'] == 2) { echo 'selected="selected"' ;}?>>Pâtes / Riz / Semoule / Blé / Lentilles</option>
												<option value="conserves" <?php if($donnees['type'] == 3) { echo 'selected="selected"' ;}?>>Conserves légumes/plats cuisinés</option>
												<option value="poisson" <?php if($donnees['type'] == 4) { echo 'selected="selected"' ;}?>>Conserves poisson</option>
												<option value="dejeuner" <?php if($donnees['type'] == 5) { echo 'selected="selected"' ;}?>>Café / Chocolat en poudre</option>
												<option value="lyophilise" <?php if($donnees['type'] == 6) { echo 'selected="selected"' ;}?>>Produits lyophilisés (soupes …)</option>
												<option value="petitsPots" <?php if($donnees['type'] == 7) { echo 'selected="selected"' ;}?>>Petits Pots ( exclusivement )</option>
												<option value="cereales" <?php if($donnees['type'] == 8) { echo 'selected="selected"' ;}?>>Biscuits / Gouters / Céréales / Biscottes</option>
												<option value="autre" <?php if($donnees['type'] == 9) { echo 'selected="selected"' ;}?>>Autres</option>
												</optgroup>
											</select>
											<br /><br />
											<input type='hidden' name='id' id='id' value=<?php echo '\'' . $_GET['id'] . '\''?> />
											<input type='submit' value='Modifier' />
										</fieldset>	
										</form>
											
											
									<?php
									}
									else
									{
										header('Location: modifier.php') ;
									}
								}
								
								
									
							}
							else
							{
								header('Location: index.php') ;
							}
						?>					
						
					</div>
			</div>
		
			<div id="pied_de_page">
			</div>
		</div>
			<?php include("codes_communs/pied_de_page.php") ; ?>
		
   </body>
</html>