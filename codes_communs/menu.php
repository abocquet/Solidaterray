<div id="menu">
			<div class="element_menu"> <!-- 'Acceuil' -->	
				<div class='titre_menu'><h3><a href='index.php'>Accueil</a></h3></div>
			</div>
			
			<div class="element_menu"> <!-- Fenetre de connection et gestion de la session -->
				<?php 
					if(!isset($_SESSION['login']) && !isset($_SESSION['passwd']))
					{
						?>
						<div class='titre_menu'><h3>Connection</h3></div>
							<div class='contenu_menu'>
								<form action='action.php' method='post'>								
									<label for='login'>Pseudo :</label><input type='text' id='login' name='login' autocomplete='off'/> <br />
									<label for='passwd'>Mot de passe :</label><input type='password' id='passwd' name='passwd' />
									<br /> <br />
									<input type='submit' value='Se connecter'/>
								</form>
								<br />
							</div>
						<?php
					}
					
					else 
					{
					?>
						<div class='titre_menu'>
							<h3>Bonjour <?php echo $_SESSION['prenom'] ; ?></h3>
						</div>
						<div class='contenu_menu'>
							<a href='home.php'><img src="images/home_link.png" title="Home" /></a>
							<a href='ajouter.php'><img src="images/ajouter_link.png" title="ajouter une entrée" /> </a>
							<a href='modifier.php'><img src="images/modifier_link.png" title="modifier ou supprimer une entrée" /></a>
							<a href='action.php?action=deconnecte'><img src="images/deconnecter_link.png" title="Se déconnecter" /></a>
						</div>
					<?php
					}
				?>
			</div>
			
			<div class="element_menu"> <!-- Classement -->
				<div class='titre_menu'><h3>Classement</h3></div>
				<div class='contenu_menu'>
				<ul>
					<!--<li><a href='classement.php?classement=1'>Classement total</a></li> Je doit décreter s'il a sa place ici lui !-->
					<li><a href='classement.php?classement=2'>Classement par points</a></li>
					<li><a href='classement.php?classement=3'>Classement par poids</a></li>
				</ul>
				</div>
			</div>
			
			<div class="element_menu"> <!-- Détail par classes -->
				<div class='titre_menu'><h3>Classement par niveau</h3></div>
				<div class='contenu_menu'>

						<ul>
							<li><a href='classement.php?classement=4&amp;classe=6'>Classement 6<sup>ème</sup></a></li>
							<li><a href='classement.php?classement=4&amp;classe=5em'>Classement 5<sup>ème</sup></a></li>
							<li><a href='classement.php?classement=4&amp;classe=4em'>Classement 4<sup>ème</sup></a></li>
							<li><a  href='classement.php?classement=4&amp;classe=3em'>Classement 3<sup>ème</sup></a></li>
						</ul>
					
				</div>
			</div>
			
			<div class="element_menu"> <!-- Détail par classes -->
				<div class='titre_menu'><h3>Historique par classe</h3></div>
				<div class='contenu_menu'>

						<ul>
							<li><a href='classement.php?classement=4&amp;classe=6&amp;groupe=1'>Classe de 6<sup>ème</sup>1</a><li>
							<li><a href='classement.php?classement=4&amp;classe=6&amp;groupe=2'>Classe de 6<sup>ème</sup>2</a><li>
							<li><a href='classement.php?classement=4&amp;classe=6&amp;groupe=3'>Classe de 6<sup>ème</sup>3</a><li>
							<li><a href='classement.php?classement=4&amp;classe=6&amp;groupe=4'>Classe de 6<sup>ème</sup>4</a><li>
							<li><a href='classement.php?classement=4&amp;classe=6&amp;groupe=5'>Classe de 6<sup>ème</sup>5</a><li>
							<li><a href='classement.php?classement=4&amp;classe=6&amp;groupe=6'>Classe de 6<sup>ème</sup>6</a><li>
						</ul>
		
						<ul>
							<li><a href='classement.php?classement=4&amp;classe=5&amp;groupe=1'>Classe de 5<sup>ème</sup>1</a><li>
							<li><a href='classement.php?classement=4&amp;classe=5&amp;groupe=2'>Classe de 5<sup>ème</sup>2</a><li>
							<li><a href='classement.php?classement=4&amp;classe=5&amp;groupe=3'>Classe de 5<sup>ème</sup>3</a><li>
							<li><a href='classement.php?classement=4&amp;classe=5&amp;groupe=4'>Classe de 5<sup>ème</sup>4</a><li>
							<li><a href='classement.php?classement=4&amp;classe=5&amp;groupe=5'>Classe de 5<sup>ème</sup>5</a><li>
							<li><a href='classement.php?classement=4&amp;classe=5&amp;groupe=6'>Classe de 5<sup>ème</sup>6</a><li>
						</ul>
					
						<ul>
							<li><a href='classement.php?classement=4&amp;classe=4&amp;groupe=1'>Classe de 4<sup>ème</sup>1</a><li>
							<li><a href='classement.php?classement=4&amp;classe=4&amp;groupe=2'>Classe de 4<sup>ème</sup>2</a><li>
							<li><a href='classement.php?classement=4&amp;classe=4&amp;groupe=3'>Classe de 4<sup>ème</sup>3</a><li>
							<li><a href='classement.php?classement=4&amp;classe=4&amp;groupe=4'>Classe de 4<sup>ème</sup>4</a><li>
							<li><a href='classement.php?classement=4&amp;classe=4&amp;groupe=5'>Classe de 4<sup>ème</sup>5</a><li>
							<li><a href='classement.php?classement=4&amp;classe=4&amp;groupe=6'>Classe de 4<sup>ème</sup>6</a><li>
						</ul>
					
						<ul>
							<li><a href='classement.php?classement=4&amp;classe=3&amp;groupe=1'>Classe de 3<sup>ème</sup>1</a><li>
							<li><a href='classement.php?classement=4&amp;classe=3&amp;groupe=2'>Classe de 3<sup>ème</sup>2</a><li>
							<li><a href='classement.php?classement=4&amp;classe=3&amp;groupe=3'>Classe de 3<sup>ème</sup>3</a><li>
							<li><a href='classement.php?classement=4&amp;classe=3&amp;groupe=4'>Classe de 3<sup>ème</sup>4</a><li>
							<li><a href='classement.php?classement=4&amp;classe=3&amp;groupe=5'>Classe de 3<sup>ème</sup>5</a><li>
							<li><a href='classement.php?classement=4&amp;classe=3&amp;groupe=6'>Classe de 3<sup>ème</sup>6</a><li>
						</ul>
					
				</div>
			</div>
		</div>