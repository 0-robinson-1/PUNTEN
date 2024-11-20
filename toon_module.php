<?php

declare(strict_types=1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'database.php';
require_once 'module_lijst.php';
require_once 'punten_lijst.php';

$moduleLijst = new ModuleLijst($conn);
$modules = $moduleLijst->getAllModules();

$selectedModuleId = isset($_POST['module']) ? (int)$_POST['module'] : null;
$grades = [];

if ($selectedModuleId) {
    $puntenLijst = new PuntenLijst($conn);
    $grades = $puntenLijst->getGradesByModule($selectedModuleId);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toon per Module</title>
</head>
<body>
    <h1>Toon per Module</h1>

    <form method="post" action="">
        <label for="module">Module:</label>
        <select name="module" id="module" required>
            <option value="">Select a module</option>
            <?php foreach ($modules as $module): ?>
                <option value="<?= $module->getIdModule() ?>" <?= $selectedModuleId === $module->getIdModule() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($module->getNaamModule()) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Show Grades</button>
    </form>

    <?php if ($selectedModuleId && !empty($grades)): ?>
        <h2>Grades for <?= htmlspecialchars($modules[array_search($selectedModuleId, array_column($modules, 'moduleID'))]->getNaamModule()) ?></h2>
        <table border="1">
            <tr>
                <th>Voornaam</th>
                <th>Familienaam</th>
                <th>Grade</th>
            </tr>
            <?php foreach ($grades as $grade): ?>
                <tr>
                    <td><?= htmlspecialchars($grade['voornaam']) ?></td>
                    <td><?= htmlspecialchars($grade['familienaam']) ?></td>
                    <td><?= htmlspecialchars((string)$grade['punt']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif ($selectedModuleId): ?>
        <p>No grades found for the selected module.</p>
    <?php endif; ?>

    <!-- Navigation button to go back to punten_ingeven.php -->
    <div style="margin-top: 20px;">
        <button onclick="window.location.href='punten_ingeven.php';">Back to Punten ingeven</button>
    </div>
</body>
</html>