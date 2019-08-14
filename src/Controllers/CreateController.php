<?php

namespace AlexVanVliet\LAP\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CreateController extends Controller
{
    public function __invoke(Request $request, $resource)
    {
        $model = $this->panel->findModel($resource);
        $config = $this->panel->getConfig($model);

        return view('lap::create')
            ->with('resource', $resource)
            ->with('model', $model)
            ->with('config', $config)
            ->with('title', Str::ucfirst(class_basename($model)));
    }
}
