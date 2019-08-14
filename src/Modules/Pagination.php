<?php

namespace AlexVanVliet\LAP\Modules;

use AlexVanVliet\LAP\AdminController;

class Pagination extends Module
{
    protected $perPage;

    public function __construct(AdminController $controller, $perPage = 25)
    {
        parent::__construct($controller);
        $this->perPage = $perPage;
    }

    public function query($query, $next)
    {
        return $next($query)->paginate($this->perPage);
    }

    public function handle($results, $next)
    {
        return $next($results)
            ->with('paginated', true)
            ->with(static::class, $this);
    }
}
