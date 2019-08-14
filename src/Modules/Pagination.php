<?php

namespace AlexVanVliet\LAP\Modules;

use AlexVanVliet\LAP\AdminController;

class Pagination extends Module
{
    protected $perPage;

    public function __construct($perPage = 25)
    {
        $this->perPage = $perPage;
    }

    public function query($request, $query, $next)
    {
        $return = $next($request, $query);
        $perPage = $this->perPage;
        $request->setFetchMethod(function ($query) use ($perPage) {
            return $query->paginate($perPage);
        });
        return $return;
    }
}
