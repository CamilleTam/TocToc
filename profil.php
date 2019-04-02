<?php
	session_start();
	
	$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
	
	if(isset($_GET['id']) AND $_GET['id'] > 0)
	{
		$getid = intval($_GET['id']);
		$requser = $bdd->prepare("SELECT * FROM MEMBRE WHERE ID=?");
		$requser->execute(array($getid));
		$userinfo = $requser->fetch();
	}
	else
	{
		header("Location:index.php");
	}
?>

<html>
	<head>
		<title>Bienvenue sur TocToc !</title>
		<meta charset="utf-8">
	</head>
	
	<body>
		<div align="center">
			<h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
			</br></br>
			Mail : <?php echo $userinfo['mail']; ?>
		</div>
	</body>
	
</html>
