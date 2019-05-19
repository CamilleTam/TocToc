<?php
	session_start();
	
	$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
	
	if(isset($_GET['id']) AND $_GET['id'] > 0)
	{
		$getid = intval($_GET['id']);
		$requser = $bdd->prepare("SELECT * FROM MEMBRES WHERE ID=?");
		$requser->execute(array($getid));
		$userinfo = $requser->fetch();
		
		if($userinfo['avatar'] == null)
		{
			$image = 'no_avatar.png';
		}
		else
		{
			$image = $userinfo['avatar'];
		}
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
		<a href="index.php">accueil</a>
		<div align="center">
			<h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
			</br></br>
			<?php
			echo '<img src="avatars/' . $image . '" alt="Avatar" width="100" height="100"> </br></br>';
			?>
			Mail : <?php echo $userinfo['mail']; ?>
			<?php if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) { ?>
			<br/><a href="annonce_form.php">Poster une annonce<a/>
			<br/><a href="my_annonces.php">Mes annonces<a/>
			<br/><a href="edit_profil.php">Editer mon profil<a/>
			<br/><a href="deconnexion.php">Se déconnecter<a/>
			<?php } ?>
		</div>
	</body>
</html>
