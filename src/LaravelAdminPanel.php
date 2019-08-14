<?php

namespace AlexVanVliet\LAP;

use AlexVanVliet\LAP\Controllers\EditController;
use AlexVanVliet\LAP\Controllers\IndexController;
use AlexVanVliet\LAP\Controllers\ShowController;
use AlexVanVliet\LAP\Controllers\UpdateController;
use AlexVanVliet\LAP\Exceptions\Exception;
use AlexVanVliet\LAP\Exceptions\ModelNotFoundException;
use Illuminate\Routing\RouteRegistrar;

class LaravelAdminPanel
{
    /**
     * @var \Illuminate\Routing\RouteRegistrar
     */
    protected $registrar;

    protected $models = [];

    protected $urls = [];

    public function __construct(RouteRegistrar $registrar)
    {
        $this->registrar = $registrar;
    }

    public function register($url, $model)
    {
        if (isset($this->models[$url])) {
            throw new Exception("$url already used.");
        }
        if (isset($this->urls[$model])) {
            throw new Exception("$model already registered.");
        }

        $this->models[$url] = $model;
        $this->urls[$model] = $url;
    }

    public function mapRoutes()
    {
        $this->registrar->get('/{resource}', IndexController::class)
            ->name('admin.index');
        $this->registrar->get('/{resource}/{id}', ShowController::class)
            ->name('admin.show');
        $this->registrar->get('/{resource}/{id}/edit', EditController::class)
            ->name('admin.edit');
        $this->registrar->put('/{resource}/{id}', UpdateController::class)
            ->name('admin.update');
    }

    public function findModel($url)
    {
        if (!isset($this->models[$url]))
            throw new ModelNotFoundException("Model for '$url' not found.");
        return $this->models[$url];
    }

    public function getConfig($model)
    {
        return array_merge(call_user_func([$model, 'getConfig']), [
            'paginate' => 25,
            'query' => function ($query) {
                return $query;
            },
        ]);
    }
}
