<?php

namespace AlexVanVliet\LAP\Modules;

use AlexVanVliet\LAP\AdminController;
use AlexVanVliet\LAP\Field;
use Illuminate\Support\Str;

class Index extends Module
{
    protected $options;

    protected $title;

    public function __construct($options = [])
    {
        $this->options = $options;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function handle($request, $results, $next)
    {
        $this->title = $this->options['title'] ??
            Str::plural(class_basename($request->getModel()));

        return $next($request, view('lap::index'))
            ->with('request', $request)
            ->with('results', $results);
    }
}
