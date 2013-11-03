<?php 
	function connection() 
	{
		$bdd = null ;
		try 
		{
			$bdd = new PDO('mysql:host=localhost;dbname=solidaterray', 'root', '');
		}
		catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
		
		return $bdd ;
	}
	
	function __autoload($nom_classe) {
		require('class/' . $nom_classe . '.class.php') ;
		}