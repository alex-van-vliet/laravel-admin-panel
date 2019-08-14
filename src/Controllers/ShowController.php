<?php

namespace AlexVanVliet\LAP\Controllers;


use AlexVanVliet\LAP\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShowController extends Controller
{
    public function __invoke(Request $request, $resource, $id)
    {
        $model = $this->panel->findModel($resource);
        $config = $this->panel->getConfig($model);
        if (!($config['pages'] & Pages::SHOW)) {
            return abort(404);
        }

        $query = $config['query'](call_user_func([$model, 'query']));
        $result = $query->findOrFail($id);

        return view('lap::show')
            ->with('resource', $resource)
            ->with('model', $model)
            ->with('result', $result)
            ->with('config', $config)
            ->with('title', Str::ucfirst(class_basename($model)));
    }
}
