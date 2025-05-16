<?php
$host = "localhost";
$dbname = "theater";
$username = "root";
$password = "";

// Stap 1: Maak databaseverbinding
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die(json_encode(["error" => "Databasefout: Kan geen verbinding maken."]));
}

// Stap 2: Repareer 'Rol'-tabel
try {
    $pdo->exec("DELETE FROM Rol WHERE Id = 0");
    $pdo->exec("ALTER TABLE Rol MODIFY COLUMN Id INT NOT NULL AUTO_INCREMENT");
    $pdo->exec("ALTER TABLE Rol AUTO_INCREMENT = 1");
} catch (PDOException $e) {
    error_log("Database fix Rol-tabel mislukt: " . $e->getMessage());
}
?>
