<?php

namespace AlexVanVliet\LAP\Modules;

use AlexVanVliet\LAP\AdminController;
use AlexVanVliet\LAP\Field;
use Illuminate\Support\Str;

class Index extends Module
{
    protected $options;

    public function __construct(AdminController $controller, $options = [])
    {
        parent::__construct($controller);

        $this->options = $options;
    }

    protected function title()
    {
        return $this->options['title'] ??
            Str::plural(class_basename($this->controller->getModel()));
    }

    protected function fields()
    {
        $fields = [];
        foreach ($this->controller->getFields() as $name => $options) {
            $fields[] = new Field($name, $options);
        }
        return $fields;
    }

    public function handle($results, $next)
    {
        return $next(view('lap::index')
            ->with('title', $this->title())
            ->with('fields', $this->fields())
            ->with('results', $results)
            ->with(static::class, $this));
    }
}
