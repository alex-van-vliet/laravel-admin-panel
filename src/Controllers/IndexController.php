<?php

namespace AlexVanVliet\LAP\Controllers;


use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request, $model)
    {
        $model = $this->panel->findModel($model);
        dd($model);
        dd($request);
    }
}
