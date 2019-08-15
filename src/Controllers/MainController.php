<?php

namespace AlexVanVliet\LAP\Controllers;

use AlexVanVliet\LAP\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MainController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('lap::main')
            ->with('panel', $this->panel);
    }
}
