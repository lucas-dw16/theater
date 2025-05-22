<?php
include('../DB/config.php');

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
$pdo = new PDO($dsn, $dbUser, $dbPass);

if (isset($_GET['Id'])) {
    $sql = "DELETE FROM Medewerker WHERE Id = :Id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':Id', $_GET['Id'], PDO::PARAM_INT);
    $statement->execute();

    echo "<div class='alert alert-success'>Medewerker succesvol verwijderd!</div>";
    header("Refresh:2; url=medewerker.php");
    exit;
} else {
    echo "<div class='alert alert-danger'>Geen ID opgegeven!</div>";
}
?>

