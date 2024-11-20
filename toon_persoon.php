<?php

declare(strict_types=1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'database.php';
require_once 'persoon_lijst.php';
require_once 'punten_lijst.php';

$persoonLijst = new PersoonLijst($conn);
$personen = $persoonLijst->getAllPersonen();

$selectedPersoonId = isset($_POST['persoon']) ? (int)$_POST['persoon'] : null;
$grades = [];

if ($selectedPersoonId) {
    $puntenLijst = new PuntenLijst($conn);
    $grades = $puntenLijst->getGradesByPerson($selectedPersoonId);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toon per Persoon</title>
</head>
<body>
    <h1>Toon per Persoon</h1>

    <form method="post" action="">
        <label for="persoon">Persoon:</label>
        <select name="persoon" id="persoon" required>
            <option value="">Select a person</option>
            <?php foreach ($personen as $persoon): ?>
                <option value="<?= $persoon->getId() ?>" <?= $selectedPersoonId === $persoon->getId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($persoon->getNaam()) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Show Grades</button>
    </form>

    <?php if ($selectedPersoonId && !empty($grades)): ?>
        <h2>Grades for <?= htmlspecialchars($personen[array_search($selectedPersoonId, array_column($personen, 'persoonID'))]->getNaam()) ?></h2>
        <table border="1">
            <tr>
                <th>Module</th>
                <th>Grade</th>
            </tr>
            <?php foreach ($grades as $grade): ?>
                <tr>
                    <td><?= htmlspecialchars($grade['naam']) ?></td>
                    <td><?= htmlspecialchars((string)$grade['punt']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif ($selectedPersoonId): ?>
        <p>No grades found for the selected person.</p>
    <?php endif; ?>

    <!-- Navigation button to go back to punten_ingeven.php -->
    <div style="margin-top: 20px;">
        <button onclick="window.location.href='punten_ingeven.php';">Back to Punten ingeven</button>
    </div>
</body>
</html>