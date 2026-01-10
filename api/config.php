<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    $env = loadEnv();
    
    $config = [
        'lookback_period' => $env['LOOKBACK_PERIOD'] ?? '7d',
        'refresh_interval' => $env['REFRESH_INTERVAL'] ?? '30s',
        'crowdsec_url' => $env['CROWDSEC_URL'] ?? 'http://localhost:8080',
        'timezone' => $env['TIMEZONE'] ?? 'Europe/Prague',
        'version' => '1.0.0',
        'lapi_status' => [
            'connected' => false,
            'last_check' => date('c')
        ]
    ];
    
    // Test LAPI connection
    try {
        $api = new CrowdSecAPI();
        $config['lapi_status']['connected'] = true;
    } catch (Exception $e) {
        $config['lapi_status']['error'] = $e->getMessage();
    }
    
    jsonResponse($config);
    
} catch (Exception $e) {
    error_log("Config API Error: " . $e->getMessage());
    jsonResponse(['error' => $e->getMessage()], 500);
}

