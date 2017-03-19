<?php
session_start();

if (isset($_SESSION['pseudo'])){
	echo 'Vous êtes connecté à la BDD, '.ucfirst(strtolower($_SESSION['pseudo'])).'. </br>';
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
<head>
  <meta charset="UTF-8">
</head>

<a href="logout.php">Se déconnecter</a>

<p> 
	<form action="page.php" method="post">
		Query Table: 
		<select name="querytable">
			<option value="client">Liste des clients</option>
			<option value="facture">Liste des factures</option>
			<option value="produits">Liste des produits</option>
		</select>
		<input type="submit" value="Send">
	</form>
	<form action="page.php" method="post">
		Query Facture: 
		<select name="queryfacture">
			<option value=""></option>
			<?php
			$reponse = $dbh->query('SELECT NumFacture FROM facture');
			while ($donnees = $reponse->fetch()){
				echo '<option value="'.$donnees['NumFacture'].'">'.$donnees['NumFacture'].'</option>';
			}
			?>
		</select>
		<input type="submit" value="Send">
	</form>

</p>

<a href="ajoutproduit.php">Ajouter Produit</a>
<a href="ajoutclient.php">Ajouter Client</a>
<a href="ajoutfacture.php">Ajouter Facture</a>

<?php
if (isset($_POST['querytable'])){
	$result = $dbh->query('select * from '.$_POST['querytable'].' limit 1');
	$fields = array_keys($result->fetch(PDO::FETCH_ASSOC));
	$reponse = $dbh->query('SELECT * FROM '.$_POST['querytable']);
	echo '<table><tr>';
	foreach ($fields as $value){
			echo '<th>'.$value.'</th>';
	}
	echo '</tr>';
	while ($donnees = $reponse->fetch())
	{
		echo '<tr>';
		foreach ($fields as $value){
			echo '<td>'.$donnees[$value].'</td>';
		}
		echo '</tr>';
	}
	
	echo '</table>';
	
}

if (isset($_POST['queryfacture']) && !empty($_POST['queryfacture'])){
	$reponse = $dbh->query('SELECT * FROM client WHERE numclient=(select numclient FROM facture WHERE numfacture='.$_POST['queryfacture'].')');
	echo '<table>';
	echo '<tr><th>Facture '.$_POST['queryfacture'].'</th></tr>';
	$donnees = $reponse->fetch();
	echo '<tr><td>'.$donnees['NumClient'].'</td><td>'.$donnees['PrenomClient'].'</td><td>'.$donnees['NomClient'].'</td></tr><tr><td>'.$donnees['AdresseClient'].'</td><td>'.$donnees['VilleClient'].'</td>
		<td>'.$donnees['CodePostalClient'].'</td><td>'.$donnees['PaysClient'].'</td></tr>';
	$reponse = $dbh->query('SELECT Produits.CodeProduit, QProduit, NomProduit, PrixUTT FROM detailfacture, produits WHERE numfacture='.$_POST['queryfacture'].' AND detailfacture.codeproduit=produits.codeproduit');
	echo '<tr><th>Code Produit</th>'.'<th>Quantité</th>'.'<th>Nom Produit</th>'.'<th>Prix UTT</th>'.'<th>Sous-Total</th></tr>';
	while ($donnees = $reponse->fetch())
	{
		echo '<tr><td>'.$donnees['CodeProduit'].'</td>'.'<td>'.$donnees['QProduit'].'</td>'.'<td>'.$donnees['NomProduit'].'</td>'.'<td>'.$donnees['PrixUTT'].'</td>'.'<td>'.$donnees['QProduit']*$donnees['PrixUTT'].'</td></tr>';
	}
	$reponse = $dbh->query('SELECT sum(PrixUTT*QProduit) as total FROM detailfacture, produits WHERE numfacture='.$_POST['queryfacture'].' AND detailfacture.codeproduit=produits.codeproduit');
	$donnees = $reponse->fetch();
	echo '<tr><th>Total</th></tr><tr><td>'.$donnees['total'].'</td></tr>';
	echo '</table>';
	
}
?>