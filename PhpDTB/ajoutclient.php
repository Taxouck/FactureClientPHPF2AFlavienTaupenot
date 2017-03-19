<?php
session_start();

if (isset($_SESSION['pseudo'])){
	//echo 'Vous êtes connecté à la BDD, '.ucfirst(strtolower($_SESSION['pseudo'])).'. </br>';
}else{
	header('Location: connection.php');
}

$servername = "mysql:dbname=mdpdtb;host=127.0.0.1";
$username = "root";
$password = "";

// Create connection
$dbh = new pdo($servername, $username, $password);

// Check connection
try {
    $dbh = new PDO($servername, $username, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

?>
<p>
	<form action="ajoutclient.php" method="post">
			Code Client:
			<input type="number" name="codec" value="" min="100000" max "999999" required></input></br>
			Nom Client:
			<input type="text" name="nomc" value="" required></input></br>
			Prénom Client:
			<input type="text" name="prenomc" value="" required></input></br>
			Adresse Client:
			<textarea name="addc" value="" required></textarea></br>
			Ville Client:
			<input type="text" name="villec" value="" required></input></br>
			Code Postal Client:
			<input type="text" name="cpc" value="" required></input></br>
			Pays Client:
			<input type="text" name="paysc" value="" required></input>
		<input type="submit" value="Send">
	</form>
</p>

<?php
if (isset($_POST['codec']) && isset($_POST['nomc']) && isset($_POST['prenomc']) && isset($_POST['addc']) && isset($_POST['villec']) && isset($_POST['cpc']) && isset($_POST['paysc'])){
	$result = $dbh->prepare('INSERT INTO `client` (`NumClient`, `NomClient`, `PrenomClient`, `AdresseClient`, `VilleClient`, `CodePostalClient`, `PaysClient`) VALUES (:codec,:nomc,:prenomc,:addc,:villec,:cpc,:paysc)');
	$result->execute(array(
					'codec' => $_POST['codec'],
					'nomc' => $_POST['nomc'],
					'prenomc' => $_POST['prenomc'],
					'addc' => $_POST['addc'],
					'villec' => $_POST['villec'],
					'cpc' => $_POST['cpc'],
					'paysc' => $_POST['paysc']
					));
	echo 'Client correctement ajouté';	
}else{
}
?>

<a href="page.php">Retour</a>