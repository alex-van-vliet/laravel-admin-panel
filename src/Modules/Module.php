<?php

namespace AlexVanVliet\LAP\Modules;


use AlexVanVliet\LAP\AdminController;

abstract class Module
{
    public function query($request, $query, $next)
    {
        return $next($request, $query);
    }

    public function handle($request, $results, $next)
    {
        return $next($request, $results)
            ->with(static::class, $this);
    }
}
