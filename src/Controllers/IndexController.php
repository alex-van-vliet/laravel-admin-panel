<?php

namespace AlexVanVliet\LAP\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    use HasSort;

    public function __invoke(Request $request, $resource)
    {
        $model = $this->panel->findModel($resource);
        $config = $this->panel->getConfig($model);

        $query = $config['query'](call_user_func([$model, 'query']));

        $names = $this->sortNames($config);
        $sort = $this->parseSort($request->get('sort', ''), $names);
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
