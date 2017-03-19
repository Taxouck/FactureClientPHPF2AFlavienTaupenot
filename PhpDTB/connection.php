<?php
session_start();

if (isset($_SESSION['pseudo'])){
	echo 'Vous êtes connecté, '.$_SESSION['pseudo'];
	header( "Location: page.php" );
}


$servername = "mysql:dbname=mdpdtb;host=127.0.0.1";
$username = "root";
$password = "";
$salt = '$ers78!!zeopms9fs88dTI';

// Create connection
$bdd = new pdo($servername, $username, $password);

// Check connection
try {
    $dbh = new PDO($servername, $username, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

if (isset($_POST['Uname']) && isset($_POST['Pswd'])){
	$username = $_POST['Uname'];
	$password = $_POST['Pswd'];
}

if (isset($_POST['NUname']) && isset($_POST['NPswd'])){
	$username = $_POST['NUname'];
	$password = $_POST['NPswd'];
	
	$sql = "INSERT INTO users (UserName, Password) VALUES (\"".$_POST['NUname']."\", \"".password_hash($_POST['NPswd'],CRYPT_BLOWFISH,["salt" => $salt])."\")";
	if ($bdd->query($sql) === TRUE) {
    echo "New user created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $bdd->error;
}
}

$reponse = $bdd->query('SELECT * FROM users');

/*if (true){
	
	while ($donnees = $reponse->fetch_assoc()){
	?>
	<p>
	<strong>Nom Utilisateur</strong> : <?php echo $donnees['UserName']; ?>
	</p>
	<p>
	<strong>Mdp</strong> : <?php echo $donnees['Password']; ?>
	</p>
	<?php
	}
	
}*/

if (isset($_POST['Uname']) && isset($_POST['Pswd'])){
	while ($donnees = $reponse->fetch()){
		if($username == $donnees['UserName']){
			//echo 'Compte trouvé';
			if(password_verify($password, $donnees['Password'])){
				$_SESSION['pseudo']=$username;
				echo 'Vous êtes connecté, '.$_SESSION['pseudo'];
				header( "Location: page.php" );
			}else{
				echo 'Mauvais mot de passe';
			}
		}
	}
}

?>
<head>
  <meta charset="UTF-8">
</head>

<p> Se connecter:
<form action="connection.php" method="post">
  Username: <input type="text" name="Uname"><br>
  Password: <input type="password" name="Pswd"><br>
  <input type="submit" value="Send">
</form> </p>

<p> Créer un compte:
<form action="connection.php" method="post"></p>
  Username: <input type="text" name="NUname"><br>
  Password: <input type="password" name="NPswd"><br>
  <input type="submit" value="Inscription">
</form> 