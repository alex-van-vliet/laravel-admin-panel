<?php

namespace AlexVanVliet\LAP\Modules;


use AlexVanVliet\LAP\AdminController;

abstract class Module
{
    protected $controller;

    public function __construct(AdminController $controller)
    {
        $this->controller = $controller;
    }

    public function query($query, $next)
    {
        return $next($query);
    }

    public function handle($results, $next)
    {
        return $next($results)
            ->with(static::class, $this);
    }
}
