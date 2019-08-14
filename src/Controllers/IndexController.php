<?php

namespace AlexVanVliet\LAP\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function __invoke(Request $request, $model)
    {
        $model = $this->panel->findModel($model);
        $config = array_merge(call_user_func([$model, 'getConfig']), [
            'paginate' => 25,
            'query' => function ($query) {
                return $query;
            },
        ]);

        $query = $config['query'](call_user_func([$model, 'query']));
        if ($config['paginate'] === false) {
            $results = $query->all();
        } else {
            $results = $query->paginate($config['paginate']);
        }

        return view('lap::index')
            ->with('results', $results)
            ->with('config', $config)
            ->with('title', Str::ucfirst(Str::plural(class_basename($model))));
    }
}
