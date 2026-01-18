<?php

/**
 * SQL Helper Functions
 * Provide reusable helpers for filtering, sorting, and WHERE clause building.
 */

function buildWhereClause(array $conditions): string {
    if (empty($conditions)) {
        return '';
    }

    return 'WHERE ' . implode(' AND ', $conditions);
}

function buildFilterConditions(array $filters, array $definitions, array &$params): array {
    $conditions = [];

    foreach ($definitions as $definition) {
        if (isset($definition['callback']) && is_callable($definition['callback'])) {
            $condition = $definition['callback']($filters, $params, $definition);
            if ($condition) {
                $conditions[] = $condition;
            }
            continue;
        }

        $key = $definition['key'] ?? null;
        $column = $definition['column'] ?? null;
        if (!$key || !$column) {
            continue;
        }

        $value = $filters[$key] ?? null;
        if (is_string($value)) {
            $value = trim($value);
        }

        if ($value === '' || $value === null) {
            continue;
        }

        $operator = $definition['operator'] ?? 'like';
        $paramKey = $definition['param'] ?? $key;
        $paramName = ':' . $paramKey;
        $transform = $definition['transform'] ?? null;
        if (is_callable($transform)) {
            $value = $transform($value, $filters);
        }

        switch ($operator) {
            case 'equals':
                $params[$paramName] = $value;
                $conditions[] = $column . ' = ' . $paramName;
                break;
            case 'gte':
                $params[$paramName] = $value;
                $conditions[] = $column . ' >= ' . $paramName;
                break;
            case 'lte':
                $params[$paramName] = $value;
                $conditions[] = $column . ' <= ' . $paramName;
                break;
            case 'gt':
                $params[$paramName] = $value;
                $conditions[] = $column . ' > ' . $paramName;
                break;
            case 'lt':
                $params[$paramName] = $value;
                $conditions[] = $column . ' < ' . $paramName;
                break;
            case 'like':
            default:
                $lowercase = $definition['lowercase'] ?? false;
                $value = (string) $value;
                if ($lowercase) {
                    $value = strtolower($value);
                }
                $params[$paramName] = '%' . $value . '%';
                $columnExpr = $lowercase ? 'LOWER(' . $column . ')' : $column;
                $conditions[] = $columnExpr . ' LIKE ' . $paramName;
                break;
        }
    }

    return $conditions;
}

function buildSortConfig(string $sort, string $dir, array $sortableColumns, string $defaultSort = ''): array {
    if ($defaultSort === '' && !empty($sortableColumns)) {
        $defaultSort = array_key_first($sortableColumns);
    }

    if (!isset($sortableColumns[$sort])) {
        $sort = $defaultSort;
    }

    $dir = strtolower(trim($dir));
    $dir = $dir === 'asc' ? 'asc' : 'desc';

    return [
        'sort' => $sort,
        'dir' => $dir,
        'order_by' => $sortableColumns[$sort] . ' ' . strtoupper($dir)
    ];
}
