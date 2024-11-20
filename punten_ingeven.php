<?php

declare(strict_types=1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'database.php';
require_once 'module_lijst.php';
require_once 'persoon_lijst.php';
require_once 'punten_lijst.php';

$moduleLijst = new ModuleLijst($conn);
$modules = $moduleLijst->getAllModules();

$persoonLijst = new PersoonLijst($conn);
$personen = $persoonLijst->getAllPersonen();

$puntenLijst = new PuntenLijst($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $persoonId = (int)$_POST['persoon'];
    $moduleId = (int)$_POST['module'];
    $grade = (int)$_POST['grade']; // Ensure grade is an integer

    try {
        if ($grade >= 0 && $grade <= 10) {
            $puntenLijst->addPunten($persoonId, $moduleId, $grade);
            echo "Grade added successfully!";
        } else {
            echo "Grade must be between 0 and 10.";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

// Close the database connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punten ingeven</title>
</head>
<body>
    <h1>Punten ingeven</h1>

    <form method="post" action="">
        <label for="persoon">Persoon:</label>
        <select name="persoon" id="persoon" required>
            <?php foreach ($personen as $persoon): ?>
                <option value="<?= $persoon->getId() ?>"><?= $persoon->getNaam() ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="module">Module :</label>
        <select name="module" id="module" required>
            <?php foreach ($modules as $module): ?>
                <option value="<?= $module->getIdModule() ?>"><?= $module->getNaamModule() ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="grade">Grade  :</label>
        <input type="number" name="grade" id="grade" min="0" max="10" step="1" required>
        <br>

        <button type="submit">Add Grade</button>
    </form>

    <!-- Navigation buttons -->
    <div style="margin-top: 20px;">
        <button onclick="window.location.href='toon_module.php';">Toon per Module</button>
    </div>
    <div style="margin-top: 20px;">
        <button onclick="window.location.href='toon_persoon.php';">Toon per persoon</button>
    </div>
</body>
</html>