<?php
session_start();
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre','root', '');
	if (isset($_POST['formconnexion'])) 
	{
		$mailconnect = htmlspecialchars($_POST['mailconnect']);
		$mdpconnect = sha1($_POST['mdpconnect']); 
		if(!empty($mailconnect) AND !empty($mdpconnect))
		{
			$requser = $bdd->prepare("SELECT * FROM membres WHERE mail=? AND motdepasse=?");
			$requser->execute(array($mailconnect,$mdpconnect));
			$userexist=$requser->rowCount();
			if($userexist == 1)
			{
				$userinfo = $requser->fetch();
				$_SESSION['id'] = $userinfo['id'];
				$_SESSION['pseudo'] = $userinfo['pseudo'];
				$_SESSION['mail'] = $userinfo['mail'];
				header("Location:profil.php?id=".$_SESSION['id']);
			}
			else
			{
				$erreur = "Mauvais Identifiant(Mail ou Mot De Passe Incorrect)";
			}
		}
		else 
		{
			$erreur ="Tous Les Champs Doivent Etre Complétés";
		}
	}
?>
<html>
	<head>
		<title>NANDO'S ESPACE</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<div align="center">
			<h3>Connexion</h3>
			<br/>
			<form method="POST" action="">
				<input type="email" name="mailconnect" placeholder="Mail"/>
				<input type="password" name="mdpconnect" placeholder="Mot De Passe"/>
				<input type="submit" name="formconnexion" value="Se Connecter"/>

			</form>
			<?php 
				if (isset($erreur))
				{
					echo '<font color="red">'.$erreur.'</font>';
				}
			?>
		</div>
	</body>
</html>