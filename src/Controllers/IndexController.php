<?php

namespace AlexVanVliet\LAP\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function keys($config)
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

    public function parseSort($queryString, $keys)
    {
        $positions = [];
        $i = 0;
        $orders = collect(explode(',', $queryString))
            ->map(function ($value) use (&$keys, &$positions, &$i) {
                if (!preg_match('((.*)_(asc|desc))i', $value, $matches)) {
                    return null;
                }
                if (!isset($keys[$matches[1]])) {
                    return null;
                }
                if (isset($positions[$matches[1]])) {
                    return null;
                }
                $positions[$matches[1]] = $i++;
                return [
                    'key' => $matches[1],
                    'name' => $keys[$matches[1]],
                    'order' => strtolower($matches[2]),
                ];
            })
            ->filter(function ($value) use (&$config) {
                return !is_null($value);
            })->toArray();
        return [
            'positions' => $positions,
            'orders' => $orders
        ];
    }

    public function handleSort($query, $sort)
    {
        foreach ($sort['orders'] as $order)
        {
            $query = $query->orderBy($order['name'], $order['order']);
        }
        return $query;
    }

    public function __invoke(Request $request, $resource)
    {
        $model = $this->panel->findModel($resource);
        $config = $this->panel->getConfig($model);

        $query = $config['query'](call_user_func([$model, 'query']));

        $keys = $this->keys($config);
        $sort = $this->parseSort($request->get('sort', ''), $keys);
        $sort['keys'] = $keys;
        $query = $this->handleSort($query, $sort);

        if (!$config['paginate']) {
            $results = $query->all();
        } else {
            $results = $query->paginate($config['paginate']);
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
