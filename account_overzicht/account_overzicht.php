<?php
session_start();
require_once '../config/db_connect.php';

try {
    $sql = "SELECT g.Id, Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, g.Isactief, g.Datumaangemaakt, r.Naam AS Rol
            FROM Gebruiker g
            LEFT JOIN Rol r ON g.Id = r.GebruikerId
            ORDER BY g.Datumaangemaakt DESC";
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    die("Fout bij ophalen van accounts: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Accountoverzicht</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .actieknop {
            padding: 6px 12px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .wijzig-knop {
            background-color: #007bff;
            color: white;
        }

        .verwijder-knop {
            background-color: #dc3545;
            color: white;
        }

        .verwijder-knop:hover, .wijzig-knop:hover {
            opacity: 0.85;
        }
    </style>
</head>
<body>
    <h1>Accountoverzicht</h1>

    <input type="text" id="zoekInput" placeholder="Zoek op naam of gebruikersnaam..." />

    <?php if ($result && $result->rowCount() > 0): ?>
        <?php if (isset($_SESSION['actie_succes'])): ?>
    <div class="success"><?= $_SESSION['actie_succes']; unset($_SESSION['actie_succes']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['actie_fout'])): ?>
    <div class="error"><?= $_SESSION['actie_fout']; unset($_SESSION['actie_fout']); ?></div>
<?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Gebruikersnaam</th>
                    <th>Rol</th>
                    <th>Actief</th>
                    <th>Aangemaakt op</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Id']) ?></td>
                        <td><?= htmlspecialchars(trim($row['Voornaam'] . ' ' . $row['Tussenvoegsel'] . ' ' . $row['Achternaam'])) ?></td>
                        <td><?= htmlspecialchars($row['Gebruikersnaam']) ?></td>
                        <td><?= htmlspecialchars($row['Rol'] ?? 'Onbekend') ?></td>
                        <td><?= $row['Isactief'] ? 'Ja' : 'Nee' ?></td>
                        <td><?= htmlspecialchars($row['Datumaangemaakt']) ?></td>
                        <td>
                            <form method="post" action="verwerk_account_acties.php" style="display:inline;">
                                <input type="hidden" name="gebruiker_id" value="<?= $row['Id'] ?>">
                                <select name="nieuwe_rol">
                                    <option value="Lid">Lid</option>
                                    <option value="Medewerker">Medewerker</option>
                                    <option value="Admin">Admin</option>
                                </select>
                                <button type="submit" name="rol_wijzigen" class="actieknop wijzig-knop">Wijzig</button>
                            </form>
                            <form method="post" action="verwerk_account_acties.php" style="display:inline;" onsubmit="return confirm('Weet je zeker dat je dit account wilt verwijderen?');">
                                <input type="hidden" name="gebruiker_id" value="<?= $row['Id'] ?>">
                                <button type="submit" name="verwijderen" class="actieknop verwijder-knop">Verwijder</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else:
 ?>
        <p class="error">Geen accounts te weergeven.</p>
    <?php endif; ?>

    <script src="script.js"></script>
</body>
</html>
