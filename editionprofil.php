<?php
session_start();
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre','root', '');
	if(isset($_SESSION['id']))
	{
		$requser = $bdd->prepare("SELECT * FROM membres WHERE id=?");
		$requser->execute(array($_SESSION['id']));
		$user=$requser->fetch();
		if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo'])
		{
			$newpseudo = htmlspecialchars($_POST['newpseudo']);
			$insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
			$insertpseudo->execute(array($newpseudo, $_SESSION['id']));
			header("Location: profil.php?id=".$_SESSION['id']);
		}

		if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail'])
		{
			$newmail = htmlspecialchars($_POST['newmail']);
			$insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
			$insertmail->execute(array($newmail, $_SESSION['id']));
			header("Location: profil.php?id=".$_SESSION['id']);
		}

		if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2']))
		{
			$mdp1 = sha1($_POST['newmdp1']);
			$mdp2 = sha1($_POST['newmdp2']);

			if($mdp1 == $mdp2)
			{
				$insertmdp= $bdd->prepare("UPDATE membres SET motdepasse = ? WHERE id = ?");
				$insertmdp->execute(array($mdp1, $_SESSION['id']));
				header("Location: profil.php?id=".$_SESSION['id']);
			}
			else
			{
				$msg="Vos Deux mdp Ne Correspondent Pas";
			}
		}
		if(isset($_POST['newpseudo']) AND $_POST['newpseudo'] == $user['pseudo'])
		{
				header("Location: profil.php?id=".$_SESSION['id']);
		}
?>
<html>
	<head>
		<title>NANDO'S ESPACE</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<div align="center">
			<h2>Edition De Mon Profil</h2>
			<div align="left">
				<form method = "POST" action="" >
					<label>Pseudo :</label>
					<input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" /><br/><br/>
					<label>Mail :</label>
					<input type="text" name="newmail" placeholder="Mail" value="<?php
					echo $user['mail'];?>"/><br/><br/>
					<label>Mot De Passe :</label>
					<input type="password" name="newmdp1" placeholder="Mot De Passe" /><br/><br/>
					<label>Confirmation-Mot De Passe :</label>
					<input type="password" name="newmdp2" placeholder="Confirmation Du Mot De Passe" /><br/><br/>	
					<input type="submit" value="Mettre A Jour Mon Profil"/><br/><br/>
				</form>
				<?php
					if(isset($msg))
					{
						echo $msg;
					}
				?>
			</div>
		</div>
	</body>
</html>
<?php 
}
else
{
	header("Location :connexion.php");
}	
 ?>