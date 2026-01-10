<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$env = loadEnv();
$appTitle = 'CrowdSec Web UI';
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $appTitle ?> - Alerty</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><?= $appTitle ?></h1>
            <nav>
                <a href="/index.php">Dashboard</a>
                <a href="/alerts.php" class="active">Alerty</a>
                <a href="/decisions.php">Rozhodnutí</a>
            </nav>
        </header>

        <main>
            <div class="page-header">
                <h2>Alerty</h2>
                <div class="filters">
                    <input type="text" id="searchAlerts" placeholder="Hledat..." />
                    <button onclick="refreshAlerts()">Obnovit</button>
                </div>
            </div>

            <div class="table-container">
                <table id="alertsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Èas</th>
                            <th>Scénáø</th>
                            <th>IP adresa</th>
                            <th>Zemì</th>
                            <th>Poèet událostí</th>
                            <th>Rozhodnutí</th>
                            <th>Akce</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal pro detail alertu -->
    <div id="alertModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="alertDetail"></div>
        </div>
    </div>

    <script src="/assets/js/app.js"></script>
    <script>
        loadAlerts();
        setInterval(loadAlerts, 30000);
    </script>
</body>
</html>

