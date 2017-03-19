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
	<form action="ajoutproduit.php" method="post">
			Code produit (auto):
			<input type="text" name="codep" value="<?php
				$reponse = $dbh->query('SELECT CodeProduit FROM produits order by CodeProduit desc');
				$donnees = $reponse->fetch();
				echo $donnees['CodeProduit']+1;
				?>" readonly>
			</input></br>
			Nom Produit:
			<input type="text" name="nomp" value="" required></input></br>
			Description Produit (facultatif):
			<textarea name="descp" value=""></textarea></br>
			Prix UTT:
			<input type="number" name="putt" value="" step="0.01" min="0" required></input>
		<input type="submit" value="Send">
	</form>
</p>

<?php
if (isset($_POST['codep']) && isset($_POST['nomp']) && isset($_POST['putt'])){
	$result = $dbh->prepare('INSERT INTO `produits` (`CodeProduit`, `NomProduit`, `DescProduit`, `PrixUTT`) VALUES (:codep,:nomp,:descp,:putt)');
	if (isset($_POST['descp']) && !empty($_POST['descp'])){
		$result->execute(array(
						'codep' => $_POST['codep'],
						'nomp' => $_POST['nomp'],
						'descp' => $_POST['descp'],
						'putt' => $_POST['putt']
						));
	} else {
		$result->execute(array(
						'codep' => $_POST['codep'],
						'nomp' => $_POST['nomp'],
						'descp' => null,
						'putt' => $_POST['putt']
						));
	}
	echo 'Produit correctement inséré';	
}else{
}
?>

<a href="page.php">Retour</a>