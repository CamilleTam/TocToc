<?php
	session_start();
	
	$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
	
	if(isset($_GET['id']) AND $_GET['id'] > 0)
	{
		$getid = intval($_GET['id']);
		
		$requser = $bdd->prepare("SELECT * FROM ANNONCE WHERE ID=?");
		$requser->execute(array($getid));
		$userinfo = $requser->fetch();
		$requser->closeCursor();
		
		$requser = $bdd->prepare("SELECT * FROM MEMBRES WHERE ID=?");
		$requser->execute(array($userinfo['id_membre']));
		$userposter = $requser->fetch();
		
		if($userposter['avatar'] == null)
		{
			$image = 'no_avatar.png';
		}
		else
		{
			$image = $userposter['avatar'];
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
			<h2><?php echo $userinfo['titre']; ?></h2>
			</br></br>
			<h3>Postée par : <?php echo $userposter['pseudo']; ?></h3>
			<?php
			echo '<img src="avatars/' . $image . '" alt="Avatar" width="100" height="100"> </br></br>';
			?>
			<h4>Lieu : <?php echo $userinfo['ville'] . ', ' . $userinfo['region'] . ', ' . $userinfo['pays']; ?></h4>
			Description : <?php echo $userinfo['texte']; ?>
		</div>
		</br></br>
		<?php
		// que les membres connectés peuvent voir les commentaires
		if($_SESSION['connected'])
		{
		?>
		
		<?php
		$requete = $bdd->prepare('SELECT * FROM commentaire WHERE id_annonce=?');
		$requete->execute(array($_GET['id']));
		$lignes = $requete->fetchAll();
		$requete->closeCursor();
		
		foreach($lignes as $ligne)
		{
			$username = $bdd->prepare('SELECT * FROM membres WHERE id=?');
			$username->execute(array($ligne['id_membre']));
			$user = $username->fetch();
			
			echo '<p>De : ' .$user['pseudo'] . '</p>';
		}
		?>
		</br></br>
		<?php
			if($_SESSION['connected'])
			{
				if(isset($_POST['formcomentaire']))
				{
					$texte = htmlspecialchars($_POST['commentaire']);
		
					$can_continue = true;

					if(empty($_POST['commentaire']))
					{
						$can_continue = false;
					}
		
					if($can_continue == true)
					{
						$insertmember = 
						$bdd->prepare("INSERT INTO commentaire(id_annonce, id_membre, texte) VALUES(?,?,?)");
						$insertmember->execute(array($_GET['id'], $_SESSION['id'], $texte));
						
						header("Location: annonce.php?id=" . $_GET['id']);
					}
				}
		?>
		<form method="POST" action="">
				<table>
					<tr>
						<td>
							<label for="story">Commentaire :</label>
							<textarea id="commentaire" name="commentaire" rows="5" cols="33"></textarea>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="center">
							<br/>
							<input type="submit" value="Poster le commentaire" name="formcomentaire"/>
						</td>
					</tr>
				</table>
			</form>		
		<?php
			}
		?>
		<?php } ?>
	</body>
</html>
