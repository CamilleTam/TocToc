<?php
	session_start();
	
	$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
		
	$requete = $bdd->prepare('SELECT * FROM annonce WHERE id_membre=?');
	$requete->execute(array($_SESSION['id']));
	$lignes = $requete->fetchAll();
	
	if(isset($_POST['idToDelete']))
	{
		$id = $_POST['idToDelete'];
		
		$requete2 = $bdd->prepare('DELETE FROM annonce WHERE id=?');
		$requete2->execute(array($id));
		header("Location: my_annonces.php");
	}
?>

<html>
	<head>
		<title>Bienvenue sur TocToc !</title>
		<meta charset="utf-8">
	</head>
	
	<body>
		<h2>Annonces en ligne</h2>
		<?php
		foreach($lignes as $ligne)
		{
			echo '<a href="annonce.php?id=' . $ligne['id'] . '">' . $ligne['titre'] . '<a/>';
			echo '<form method="post" action="my_annonces.php">
			<input type="submit" name="idToDelete" value="' . $ligne['id'] . '"/>
			</form><br/>';
		}
		?>
	</body>
	
</html>