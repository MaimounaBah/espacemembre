<?php
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre','root', '');
	if(isset($_POST['forminscription']))
	{
			$pseudo = htmlspecialchars($_POST['pseudo']);
			$mail = htmlspecialchars($_POST['mail']);
			$mail2 = htmlspecialchars($_POST['mail2']);
			$mdp = sha1($_POST['mdp']);
			$mdp2 = sha1($_POST['mdp2']);
		if (!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) 
		{
			$pseudolength = strlen($pseudo);
			if ($pseudolength <= 255)
			 {
					if ($mail == $mail2)
					{
						if (filter_var($mail, FILTER_VALIDATE_EMAIL))
						{ 
							$reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail=?");
							$reqmail ->execute(array($mail));
							$mailexist = $reqmail->rowCount();
							if($mailexist == 0)
							{
								if ($mdp == $mdp2 )
								{
									$insertmbr =$bdd->prepare("INSERT INTO membres(pseudo,mail,motdepasse) values(?,?,?)");
									$insertmbr ->execute(array($pseudo,$mail,$mdp));
									$erreur="Votre Compte A Bien Eté Crée ! <a href=\"connexion.php\"> Me Connecter</a>";
								}
								else
								{
									$erreur="Vos Mots De Passes Ne Correspondent Pas !";
								}
							}
							else
							{
								$erreur ="Adresse Mail Deja Utilisee";
							}
						}

						else
						{
							$erreur="Votre Adresse Mail N'est Pas Valide";
						}
					}
					else
					{
						$erreur ="Vos Adresses Mail Ne Correspondent Pas !";
					}
			 }
			 else
			 {
			 	$erreur ="Votre Pseudo Ne Doit Pas Depasser 255 Carractères !";
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
			<h3>Inscription</h3>
			<br/>
			<form method="POST" action="">
				<table>
					<tr>
						<td align="right">
							<label for="pseudo">Pseudo :</label>
						</td>
						<td>
							<input type="text" placeholder="Votre Pseudo"
							name="pseudo" id="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo;}?>"/>
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="mail">Mail :</label>
						</td>
						<td>
							<input type="email"	placeholder="Votre Mail"
							name="mail" id="mail" value="<?php if(isset($mail)) { echo $mail;}?>"/>
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="mail2">Confirmation Mail:</label>
						</td>
						<td>
							<input type="email" placeholder="Confirmez Votre Mail"
							name="mail2" id="mail2" value="<?php if(isset($mail2)) { echo $mail2;}?>" />
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="mdp">Mot De Passe :</label>
						</td>
						<td>
							<input type="password" placeholder="Votre Mot De Passe"
							name="mdp" id="mdp"/>
						</td>
					</tr>

					<tr>
						<td align="right">
							<label for="mdp2">Confirmation Mot De Passe: </label>
						</td>
						<td>
							<input type="password" placeholder="Confirmez Votre MDP"
							name="mdp2" id="mdp2"/>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="submit" name="forminscription" value="Je M'inscris"/>
						</td>
					</tr>
				</table>
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