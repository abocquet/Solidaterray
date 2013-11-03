<?php 		
	session_start() ;
	

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
							?>
								<form method='post' action='action.php'>
									<fieldset>
										<legend>Ajouter une entrée</legend>
										Poids : <input type='text' name='poid_kg' id='poid_kg' value='0' autocomplete='off' onFocus="value=''"/> kg <input type='text' name='poid_g' id='poid_kg' value='0' autocomplete='off' onFocus="value=''"/> g
										<br /><br />
										Type : 
										<select name='type' id='type'>
											<optgroup label='--- Type ---' >
											<option value="poudres">Poudres (sel/sucre/farine/poivre …)</option>
											<option value="pondereux">Pâtes / Riz / Semoule / Blé / Lentilles</option>
											<option value="conserves">Conserves légumes/plats cuisinés</option>
											<option value="poisson">Conserves poisson</option>
											<option value="dejeuner">Café / Chocolat en poudre</option>
											<option value="lyophilise">Produits lyophilisés (soupes …)</option>
											<option value="petitsPots">Petits Pots ( exclusivement )</option>
											<option value="cereales">Biscuits / Gouters / Céréales / Biscottes</option>
											<option value="autre" selected="selected">Autres</option>
											</optgroup>
										</select>
										<br /><br />
										Classe :
										<select name='classe' id='classe'>
											<optgroup label='--- Sixèmes ---' >
											<option value="61">6<sup>èm</sup> 1</option>
											<option value="62">6<sup>èm</sup> 2</option>
											<option value="63">6<sup>èm</sup> 3</option>
											<option value="64">6<sup>èm</sup> 4</option>
											<option value="65">6<sup>èm</sup> 5</option>
											<option value="66">6<sup>èm</sup> 6</option>
											</optgroup>
											<optgroup label='--- Cinquièmes ---' >
											<option value="51">5<sup>èm</sup> 1</option>
											<option value="52">5<sup>èm</sup> 2</option>
											<option value="53">5<sup>èm</sup> 3</option>
											<option value="54">5<sup>èm</sup> 4</option>
											<option value="55">5<sup>èm</sup> 5</option>
											<option value="56">5<sup>èm</sup> 6</option>
											</optgroup>
											<optgroup label='--- Quatrièmes ---' >
											<option value="41">4<sup>èm</sup> 1</option>
											<option value="42">4<sup>èm</sup> 2</option>
											<option value="43">4<sup>èm</sup> 3</option>
											<option value="44">4<sup>èm</sup> 4</option>
											<option value="45">4<sup>èm</sup> 5</option>
											<option value="46">4<sup>èm</sup> 6</option>
											</optgroup>
											<optgroup label='--- Troisièmes ---' >
											<option value="31">3<sup>èm</sup> 1</option>
											<option value="32">3<sup>èm</sup> 2</option>
											<option value="33">3<sup>èm</sup> 3</option>
											<option value="34">3<sup>èm</sup> 4</option>
											<option value="35">3<sup>èm</sup> 5</option>
											<option value="36">3<sup>èm</sup> 6</option>
											</optgroup>
										</select>
										
										<br /> <br /><br />
										<input type='submit' value='Envoyer' />
									</fieldset>
								</form>
							<?php
						}
						else
						{
							header('Location: index.php') ;
						}
						?>
						<div class='message'>
						<?php
						if (isset($_SESSION['message']))
						{
							echo $_SESSION['message'] ;
							$_SESSION['message'] = '' ;
						}
						?>
						</div>
					
					</div>
			</div>
			
			<div id="pied_de_page">
			</div>
		</div>
			<?php include("codes_communs/pied_de_page.php") ; ?>
		
   </body>
</html>