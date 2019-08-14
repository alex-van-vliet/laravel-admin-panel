<?php

namespace AlexVanVliet\LAP\Controllers;

trait HasSort
{
    public function sortNames($config)
    {
        return collect($config['fields'])
            ->filter(function ($field) {
                return $field->sortKey();
            })
            ->mapWithKeys(function ($field) {
                return [$field->sortKey() => $field->name()];
            })
            ->toArray();
    }

    public function parseSort($queryString, $names)
    {
        $positions = [];
        $i = 0;
        $orders = collect(explode(',', $queryString))
            ->map(function ($value) use (&$names, &$positions, &$i) {
                if (!preg_match('(^(.*)_(asc|desc)$)i', $value, $matches)) {
                    return null;
                }
                if (!isset($names[$matches[1]])) {
                    return null;
                }
                if (isset($positions[$matches[1]])) {
                    return null;
                }
                $positions[$matches[1]] = $i++;
                return [
                    'key' => $matches[1],
                    'name' => $names[$matches[1]],
                    'order' => strtolower($matches[2]),
                ];
            })
            ->filter(function ($value) use (&$config) {
                return !is_null($value);
            })->toArray();
        return [
            'positions' => $positions,
            'orders' => $orders,
            'names' => $names,
            'url' => $this->sortQueryString(),
            'order' => $this->sortOrder(),
            'position' => $this->sortPosition(),
        ];
    }

    public function handleSort($query, $sort)
    {
        foreach ($sort['orders'] as $order) {
            $query = $query->orderBy($order['name'], $order['order']);
        }
        return $query;
    }

    public function sortQueryString()
    {
        return function ($sort, $field) {
            $key = $field->sortKey();
            $orders = $sort['orders'];
            if (isset($sort['positions'][$key])) {
                if ($orders[$sort['positions'][$key]]['order'] === 'desc') {
                    unset($orders[$sort['positions'][$key]]);
                } else {
                    $orders[$sort['positions'][$key]]['order'] = 'desc';
                }
            } else {
                array_push($orders, [
                    'key' => $key,
                    'order' => 'asc',
                ]);
            }
            return urlencode(collect($orders)
                ->map(function ($order) {
                    return $order['key'].'_'.$order['order'];
                })
                ->implode(','));
        };
    }

    public function sortOrder()
    {
        return function ($sort, $field) {
            $key = $field->sortKey();
            if (isset($sort['positions'][$key])) {
                return $sort['orders'][$sort['positions'][$key]]['order'];
            }
            return null;
        };
    }

    public function sortPosition()
    {
        return function ($sort, $field) {
            $key = $field->sortKey();
            if (isset($sort['positions'][$key])) {
                return $sort['positions'][$key];
            }
            return -1;
        };
    }
}
