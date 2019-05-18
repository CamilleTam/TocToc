<?php
	session_start();
	
	if(!isset($_SESSION['connected']))
	{
		$_SESSION['connected'] = false;
	}
	
	// header("Location: insc.php");
?>

<html>
	<head>
		<title>Bienvenue sur TocToc !</title>
		<meta charset="utf-8">
	</head>
	
	<body>
		<?php if($_SESSION['connected'])
		{
			echo '<a href="profil.php?id=' . $_SESSION['id'] . '"><button>MON PROFIL</button></a>';
		}
		else { ?>
		<a href="insc.php"><button>INSCRIPTION</button></a>
		<a href="connexion.php"><button>CONNEXION</button></a>
		<?php } ?>
		
		</br></br>
		<h2>Annonces en ligne</h2>
		
		<?php // la j'affiche toutes les annonces du site : on pourrait faire un truc du style "dernières annonces"
		
		$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
		
		$requete = $bdd->query('SELECT * FROM annonce;');
		$lignes = $requete->fetchAll();
		$requete->closeCursor();
		
		foreach($lignes as $ligne)
		{
			echo '<a href="annonce.php?id=' . $ligne['id'] . '">' . $ligne['titre'] . '<a/></br>';
		}
		
		?>
	</body>
	
</html>