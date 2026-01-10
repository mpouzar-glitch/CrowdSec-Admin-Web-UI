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
    <title><?= $appTitle ?> - Dashboard</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1><?= $appTitle ?></h1>
            <nav>
                <a href="/index.php" class="active">Dashboard</a>
                <a href="/alerts.php">Alerty</a>
                <a href="/decisions.php">Rozhodnutí</a>
            </nav>
        </header>

        <main>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Celkem alertù</h3>
                    <div class="stat-value" id="totalAlerts">-</div>
                </div>
                
                <div class="stat-card">
                    <h3>Aktivní bany</h3>
                    <div class="stat-value" id="activeDecisions">-</div>
                </div>
                
                <div class="stat-card">
                    <h3>Top scénáø</h3>
                    <div class="stat-value small" id="topScenario">-</div>
                </div>
                
                <div class="stat-card">
                    <h3>Top zemì</h3>
                    <div class="stat-value" id="topCountry">-</div>
                </div>
            </div>

            <div class="charts-grid">
                <div class="chart-container">
                    <h3>Aktivita za posledních 24 hodin</h3>
                    <canvas id="timelineChart"></canvas>
                </div>
                
                <div class="chart-container">
                    <h3>Top 10 scénáøù</h3>
                    <canvas id="scenariosChart"></canvas>
                </div>
            </div>

            <div class="tables-grid">
                <div class="table-container">
                    <h3>Top 10 zemí</h3>
                    <table id="countriesTable">
                        <thead>
                            <tr>
                                <th>Zemì</th>
                                <th>Poèet</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                
                <div class="table-container">
                    <h3>Top 10 IP adres</h3>
                    <table id="ipsTable">
                        <thead>
                            <tr>
                                <th>IP adresa</th>
                                <th>Poèet</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="/assets/js/app.js"></script>
    <script>
        // Load dashboard data
        loadDashboard();
        
        // Refresh every 30 seconds
        setInterval(loadDashboard, 30000);
    </script>
</body>
</html>

