<?php
require_once __DIR__ . '/sql_helper.php';

function buildAlertsWhereClause(array $filters, array &$params): string {
    $definitions = [
        [
            'key' => 'ip',
            'column' => 'source_ip',
            'operator' => 'equals'
        ],
        [
            'key' => 'scenario',
            'column' => 'scenario',
            'operator' => 'like',
            'lowercase' => false
        ],
        [
            'key' => 'country',
            'column' => 'source_country',
            'operator' => 'equals'
        ],
        [
            'key' => 'date_from',
            'column' => 'created_at',
            'operator' => 'gte',
            'transform' => function ($value) {
                return $value . ' 00:00:00';
            }
        ],
        [
            'key' => 'date_to',
            'column' => 'created_at',
            'operator' => 'lte',
            'transform' => function ($value) {
                return $value . ' 23:59:59';
            }
        ],
        [
            'key' => 'simulated',
            'column' => 'simulated',
            'operator' => 'equals',
            'transform' => function ($value) {
                return (int) $value;
            }
        ],
    ];

    $conditions = buildFilterConditions($filters, $definitions, $params);
    return buildWhereClause($conditions);
}

function buildAlertsSort(string $sort, string $sortDir, array $sortableColumns): array {
    return buildSortConfig($sort, $sortDir, $sortableColumns, 'created_at');
}
