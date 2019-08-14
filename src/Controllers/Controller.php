<?php

namespace AlexVanVliet\LAP\Controllers;

use AlexVanVliet\LAP\LaravelAdminPanel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var \AlexVanVliet\LAP\LaravelAdminPanel
     */
    protected $panel;

    public function __construct(LaravelAdminPanel $panel)
    {
        $this->panel = $panel;
    }
}
