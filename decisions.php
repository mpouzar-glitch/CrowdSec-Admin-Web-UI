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
    <title><?= $appTitle ?> - Rozhodnutí</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><?= $appTitle ?></h1>
            <nav>
                <a href="/index.php">Dashboard</a>
                <a href="/alerts.php">Alerty</a>
                <a href="/decisions.php" class="active">Rozhodnutí</a>
            </nav>
        </header>

        <main>
            <div class="page-header">
                <h2>Rozhodnutí (Bany)</h2>
                <div class="filters">
                    <label>
                        <input type="checkbox" id="includeExpired" onchange="loadDecisions()"> 
                        Zobrazit expirované
                    </label>
                    <label>
                        <input type="checkbox" id="hideDuplicates" checked onchange="filterDuplicates()"> 
                        Skrýt duplikáty
                    </label>
                    <button onclick="showAddDecisionModal()">Pøidat ban</button>
                    <button onclick="refreshDecisions()">Obnovit</button>
                </div>
            </div>

            <div class="table-container">
                <table id="decisionsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Èas</th>
                            <th>IP adresa</th>
                            <th>Typ</th>
                            <th>Scénáø</th>
                            <th>Zemì</th>
                            <th>Expirace</th>
                            <th>Status</th>
                            <th>Akce</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal pro pøidání banu -->
    <div id="addDecisionModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Pøidat nový ban</h3>
            <form id="addDecisionForm">
                <div class="form-group">
                    <label>IP adresa:</label>
                    <input type="text" id="banIp" required placeholder="192.168.1.1">
                </div>
                <div class="form-group">
                    <label>Doba trvání:</label>
                    <select id="banDuration">
                        <option value="1h">1 hodina</option>
                        <option value="4h" selected>4 hodiny</option>
                        <option value="24h">24 hodin</option>
                        <option value="168h">7 dní</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Dùvod:</label>
                    <input type="text" id="banReason" value="manual" placeholder="manual">
                </div>
                <button type="submit">Pøidat ban</button>
            </form>
        </div>
    </div>

    <script src="/assets/js/app.js"></script>
    <script>
        loadDecisions();
        setInterval(loadDecisions, 30000);
    </script>
</body>
</html>

