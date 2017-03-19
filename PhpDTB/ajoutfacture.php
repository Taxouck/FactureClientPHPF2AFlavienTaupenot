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

$i=1;

?>
<?php
if (isset($_POST['codef']) && isset($_POST['codec'])){
	$result = $dbh->prepare('INSERT INTO `facture` (`NumFacture`, `NumClient`) VALUES (:codef,:codec)');
	$result->execute(array(
					'codef' => $_POST['codef'],
					'codec' => $_POST['codec']
					));
	echo 'Facture correctement créée';	
}else{
}
?>
<?php
if (isset($_POST['codef']) && isset($_POST['codep']) && isset($_POST['qttp'])){
	$result = $dbh->prepare('INSERT INTO `detailfacture` (`NumFacture`, `CodeProduit`, `QProduit`) VALUES (:codef,:codep,:qttp)');
	$result->execute(array(
					'codef' => $_POST['codef'],
					'codep' => $_POST['codep'],
					'qttp' => $_POST['qttp']
					));
	echo 'Produit correctement ajouté à la facture';	
}else{
}
?>
<p> Créer une nouvelle facture
	<form action="ajoutfacture.php" method="post">
		Code Facture:
		<input type="number" name="codef" value="" min="100000" max="999999" required></input></br>
		Code Client:
		<select name="codec" required>
			<option value=""></option>
			<?php
				$reponse = $dbh->query('SELECT NumClient FROM client');
				while ($donnees = $reponse->fetch()){
					echo '<option value="'.$donnees['NumClient'].'">'.$donnees['NumClient'].'</option>';
				}
			?>
		</select></br>
		<input type="submit" value="Send">
	</form>
</p>

<p> Ajouter des produits à une facture existante
	<form action="ajoutfacture.php" method="post">
		Code Facture:
		<select name="codef" required>
			<option value=""></option>
			<?php
				$reponse = $dbh->query('SELECT NumFacture FROM facture');
				while ($donnees = $reponse->fetch()){
					echo '<option value="'.$donnees['NumFacture'].'">'.$donnees['NumFacture'].'</option>';
				}
			?>
		</select></br>
		Code Produit:
		<select name="codep" required>
			<option value=""></option>
			<?php
				$reponse = $dbh->query('SELECT CodeProduit FROM produits');
				while ($donnees = $reponse->fetch()){
					echo '<option value="'.$donnees['CodeProduit'].'">'.$donnees['CodeProduit'].'</option>';
				}
			?>
		</select></br>
		Quantité:
		<input type="number" name="qttp" value="" min="0" max="999999" required></input></br>
		<input type="submit" value="Send">
	</form>
</p>

<a href="page.php">Retour</a>