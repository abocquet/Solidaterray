<?php
	function refresh ($niveau, $groupe)
	{
		global $bdd;
		
		$req = $bdd->prepare('SELECT SUM(poid) AS poid_total FROM entrees WHERE niveau = ? AND groupe = ?') ;
		$req->execute(array($niveau, $groupe)) ;
			
		$donnees = $req->fetch() ;
		$poid_total = round($donnees['poid_total'], 2) ;
		$req->closeCursor() ;
			
		$req = $bdd->prepare('SELECT SUM(point) AS points_totaux FROM entrees WHERE niveau = ? AND groupe = ?') ;
		$req->execute(array($niveau, $groupe)) ;
			
		$donnees = $req->fetch() ;
		$points_totaux = $donnees['points_totaux'] ;
		$req->closeCursor() ;
			
		$total = $poid_total * $points_totaux ;
			
		$req = $bdd->prepare('UPDATE classe SET poid = :poid, point = :point, total = :total WHERE niveau = :niveau AND groupe = :groupe') ;
		$req->execute(array(
			'poid' => $poid_total, 
			'point' => $points_totaux, 
			'total' => $total,
			'niveau' => $niveau,
			'groupe' => $groupe
		)) ;
	}
	
	
	session_start() ;
	try 
	{
		$bdd = new PDO('mysql:host=localhost;dbname=solidaterray', 'root', '');
	}
	catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}
	
	if (isset($_POST['login']) && isset($_POST['passwd'])) // Connection
	{
		$login = $_POST['login'] ;
		$passwd = sha1($_POST['passwd']) ;
		
		$req = $bdd->prepare('SELECT * FROM membre WHERE pseudo = ? AND pass = ?') ;
		$req->execute(array($login, $passwd)) ;
		
		$donnees = $req->fetch() ;
	
		if($donnees)
		{
			$_SESSION['login'] = $login ;
			$_SESSION['passwd'] = $passwd ;
			$_SESSION['admin'] = $donnees['administrateur'] ;
			$_SESSION['nom'] = $donnees['nom'] ;
			$_SESSION['prenom'] = $donnees['prenom'] ;
			$_SESSION['id'] = $donnees['id'] ;
			
			
		}	
		header('Location: home.php') ;
		$req->closeCursor() ;
		
	}
	
	elseif (isset($_GET['action']) && $_GET['action'] == 'deconnecte') // Déconnection
	{
		$_SESSION = array() ;
		session_destroy() ;
			
		header('Location: index.php') ;
	}
	
	elseif(isset($_POST['poid_kg']) && isset($_POST['poid_g']) && isset($_POST['type']) && isset($_POST['classe'])) // Ajout d'une entrée
	{
		//Détermination de la classe (niveau et groupe)
		{
		if ($_POST['classe'] > 60 && $_POST['classe'] < 67)
		{
			$niveau = 6 ;
		}
		elseif ($_POST['classe'] > 50 && $_POST['classe'] < 57)
		{
			$niveau = 5 ;
		}
		elseif ($_POST['classe'] > 40 && $_POST['classe'] < 47)
		{
			$niveau = 4 ;
		}
		elseif ($_POST['classe'] > 30 && $_POST['classe'] < 37)
		{
			$niveau = 3 ;
		}
		else
		{
			$_SESSION['message'] = 'Il ne faut pas trafiquer le HTML !' ;
			header('Location: ajouter.php');
			return 0 ;
		}
		
		$groupe = (int) $_POST['classe'] % 10 ;
	}
	
		//Détermination du poids
		{
			$poid = 0 ;
			$poid = abs((double) $_POST['poid_kg'] + ((int) $_POST['poid_g'] / 1000)) ;
			
			if($poid == 0)
			{
				$_SESSION['message'] = 'Il ne faut pas entrer un ajout qui a un poid nul !' ;
				header('Location: ajouter.php');
				return 0 ;
			}
		}
		
		//Détermination du type
		{
			/*
				Code : 1  / Poudres (sel/sucre/farine/poivre …)         : 1 pts/kg
				Code : 2  / Pâtes / Riz / Semoule / Blé / Lentilles     : 10 pts/kg
				Code : 3  / Conserves légumes/plats cuisinés            : 20 pts/kg
				Code : 4  / Conserves poisson                           : 40 pts/kg
				Code : 5  / Café / Chocolat en poudre                   : 50 pts/kg
				Code : 6  / Produits lyophilisés (soupes …)             : 70 pts/kg
				Code : 7  / Petits Pots ( exclusivement )               : 90 pts/kg
				Code : 8  / Biscuits / Gouters / Céréales / Biscottes   : 70 pts/kg
				Code : 9  / AUTRES                                      : 10 pts/kg
				Code : 0  / ERREUR										: envoie d'un message d'erreur
			*/
			
				if ($_POST['type'] == 'poudres')
				{
					$type = 1;
					$points = $poid * 1;
				}
				elseif ($_POST['type'] == 'pondereux')
				{
					$type = 2;
					$points = $poid * 10;
				}
				elseif ($_POST['type'] == 'conserves')
				{
					$type = 3;
					$points = $poid * 20;
				}
				elseif ($_POST['type'] == 'poisson')
				{
					$type = 4;
					$points = $poid * 40;
				}
				elseif ($_POST['type'] == 'dejeuner')
				{
					$type = 5;
					$points = $poid * 50;
				}
				elseif ($_POST['type'] == 'lyophilise')
				{
					$type = 6;
					$points = $poid * 70;
				}
				elseif ($_POST['type'] == 'petitsPots')
				{
					$type = 7;
					$points = $poid * 90;
				}
				elseif ($_POST['type'] == 'cereales')
				{
					$type = 8;
					$points = $poid * 70;
				}
				elseif ($_POST['type'] == 'autre')
				{
					$type = 9;
					$points = $poid * 10;
				}
				else
				{
					$_SESSION['message'] = 'Il ne faut pas truquer la page et envoiyer un type à la c... !' ;
					header('Location: ajouter.php');
					return 0 ;
				}	
		}
		
		//Ajout de l'entrée
		{
			$req = $bdd->prepare('INSERT INTO entrees (poid, type, id_ajout, point, niveau, groupe, date_ajout) VALUES (:poid, :type, :id_ajout, :points, :niveau, :groupe, NOW())') ;
			$req->execute(array(
				'poid' => $poid ,
				'type' => $type ,
				'id_ajout' => $_SESSION['id'] ,
				'points' => $points ,
				'niveau' => $niveau ,
				'groupe' => $groupe ,	
			)) ;
		}
		
		$_SESSION['message'] = 'L\' entrée a bien été ajoutée.' ;
		refresh($niveau, $groupe) ;
		
		header('Location: ajouter.php');
	}
	
	elseif (isset($_POST['poid_kg']) && isset($_POST['poid_g']) && isset($_POST['type']) && isset($_POST['id'])) // Modification d'une entrée
	{
	
		$req = $bdd->prepare('SELECT id_ajout, niveau, groupe FROM entrees WHERE id = ?') ;
		$req->execute(array($_POST['id'])) ;
		
		$donnees = $req->fetch();
		$req->closeCursor() ;
			
		if($donnees && ($donnees['id_ajout'] == $_SESSION['id'] ||  $_SESSION['admin'] == 1))
		{
			//Détermination du poids
			{
				$poid = 0 ;
				$poid = abs((double) $_POST['poid_kg'] + ((int) $_POST['poid_g'] / 1000)) ;
				
				if($poid == 0)
				{
					$_SESSION['message'] = 'Il ne faut pas entrer un ajout qui a un poid nul !' ;
					header('Location: modifier.php');
					return 0 ;
				}
			}
		
			//Détermination du type
			{
				/*
					Code : 1  / Poudres (sel/sucre/farine/poivre …)         : 1 pts/kg
					Code : 2  / Pâtes / Riz / Semoule / Blé / Lentilles     : 10 pts/kg
					Code : 3  / Conserves légumes/plats cuisinés            : 20 pts/kg
					Code : 4  / Conserves poisson                           : 40 pts/kg
					Code : 5  / Café / Chocolat en poudre                   : 50 pts/kg
					Code : 6  / Produits lyophilisés (soupes …)             : 70 pts/kg
					Code : 7  / Petits Pots ( exclusivement )               : 90 pts/kg
					Code : 8  / Biscuits / Gouters / Céréales / Biscottes   : 70 pts/kg
					Code : 9  / AUTRES                                      : 10 pts/kg
					Code : 0  / ERREUR										: envoie d'un message d'erreur
				*/
			
				if ($_POST['type'] == 'poudres')
				{
					$type = 1;
					$points = $poid * 1;
				}
				elseif ($_POST['type'] == 'pondereux')
				{
					$type = 2;
					$points = $poid * 10;
				}
				elseif ($_POST['type'] == 'conserves')
				{
					$type = 3;
					$points = $poid * 20;
				}
				elseif ($_POST['type'] == 'poisson')
				{
					$type = 4;
					$points = $poid * 40;
				}
				elseif ($_POST['type'] == 'dejeuner')
				{
					$type = 5;
					$points = $poid * 50;
				}
				elseif ($_POST['type'] == 'lyophilise')
				{
					$type = 6;
					$points = $poid * 70;
				}
				elseif ($_POST['type'] == 'petitsPots')
				{
					$type = 7;
					$points = $poid * 90;
				}
				elseif ($_POST['type'] == 'cereales')
				{
					$type = 8;
					$points = $poid * 70;
				}
				elseif ($_POST['type'] == 'autre')
				{
					$type = 9;
					$points = $poid * 10;
				}
				else
				{
					$_SESSION['message'] = 'Il ne faut pas truquer la page et envoiyer un type à la c... !' ;
					header('Location: ajouter.php');
					return 0 ;
				}	
			}
			
			$groupe = $donnees['groupe'] ;
			$niveau = $donnees['niveau'] ;
				
			$req = $bdd->prepare('UPDATE entrees SET poid = :poid, type = :type, point = :point WHERE id = :id') ;
			$req->execute(array(
						'poid' => $poid,
						'type' => $type, 
						'point' => $points,
						'id' => $_POST['id']
			)) ;
		
		
			$_SESSION['message'] = 'L\' entrée a bien été modifiée.' ;
			refresh($niveau, $groupe) ;
		}
		else 
		{
			$_SESSION['message'] = 'Vous n\'êtes pas autorisé à modifier cette entrée.' ;
			header('Location: modifier.php');
			return 0 ;
		}
		
		
		header('Location: modifier.php');
	}
	
	elseif(isset($_GET['id']) &&  isset($_GET['action']) && $_GET['action'] == 'supprimer') // Suppression d'une entrée 
	{
		
		$req = $bdd->prepare('SELECT id_ajout, niveau, groupe FROM entrees WHERE id = ?') ;
		$req->execute(array($_GET['id'])) ;
		
		$donnees = $req->fetch();
		$req->closeCursor() ;
		
		$groupe = $donnees['groupe'] ;
		$niveau = $donnees['niveau'] ;
			
		if($donnees && ($donnees['id_ajout'] == $_SESSION['id'] ||  $_SESSION['admin'] == 1))
		{
			$req = $bdd->prepare('DELETE FROM entrees WHERE id = ?') ;
			$req->execute(array($_GET['id'])) ;
			
			refresh($donnees['niveau'], $donnees['groupe']) ;
			
			$_SESSION['message'] = 'L\'entrée avec l\'identifiant ' . $_GET['id'] . ' à bien été supprimé<br />' ;
		}
		
		else 
		{
			$_SESSION['message'] = 'Vous n\'êtes pas autorisé à modifier cette entrée.' ;
			header('Location: modifier.php');
			return 0 ;
		}
		
		refresh($niveau, $groupe) ;
		
		header('Location: modifier.php');
	}
	
	else // redirection vers la page d'acceuil si les parametres ne sont pas valables
	{
		header('Location: index.php') ;
	}
?>