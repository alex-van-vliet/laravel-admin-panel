<?php

namespace AlexVanVliet\LAP\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function names($config)
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
        ];
    }

    public function handleSort($query, $sort)
    {
        foreach ($sort['orders'] as $order) {
            $query = $query->orderBy($order['name'], $order['order']);
        }
        return $query;
    }

    public function sortQueryString(&$sort)
    {
        return function ($field) use (&$sort) {
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

    public function sortOrder(&$sort)
    {
        return function ($field) use (&$sort) {
            $key = $field->sortKey();
            if (isset($sort['positions'][$key])) {
                return $sort['orders'][$sort['positions'][$key]]['order'];
            }
            return null;
        };
    }

    public function sortPosition(&$sort)
    {
        return function ($field) use (&$sort) {
            $key = $field->sortKey();
            if (isset($sort['positions'][$key])) {
                return $sort['positions'][$key];
            }
            return -1;
        };
    }

    public function __invoke(Request $request, $resource)
    {
        $model = $this->panel->findModel($resource);
        $config = $this->panel->getConfig($model);

        $query = $config['query'](call_user_func([$model, 'query']));

        $names = $this->names($config);
        $sort = $this->parseSort($request->get('sort', ''), $names);
        $sort['names'] = $names;
        $sort['url'] = $this->sortQueryString($sort);
        $sort['order'] = $this->sortOrder($sort);
        $sort['position'] = $this->sortPosition($sort);
        $query = $this->handleSort($query, $sort);

        if (!$config['paginate']) {
            $results = $query->all();
        } else {
            $results = $query->paginate($config['paginate']);
            if ($request->has('sort')) {
                $results->appends(['sort' => $request->get('sort')]);
            }
        }

        return view('lap::index')
            ->with('resource', $resource)
            ->with('model', $model)
            ->with('results', $results)
            ->with('config', $config)
            ->with('sort', $sort)
            ->with('title', Str::ucfirst(Str::plural(class_basename($model))));
    }
}
