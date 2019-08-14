<?php

namespace AlexVanVliet\LAP;

use AlexVanVliet\LAP\Controllers\CreateController;
use AlexVanVliet\LAP\Controllers\DeleteController;
use AlexVanVliet\LAP\Controllers\DestroyController;
use AlexVanVliet\LAP\Controllers\EditController;
use AlexVanVliet\LAP\Controllers\IndexController;
use AlexVanVliet\LAP\Controllers\ShowController;
use AlexVanVliet\LAP\Controllers\StoreController;
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

        $this->registrar->get('/{resource}/create', CreateController::class)
            ->name('admin.create');
        $this->registrar->post('/{resource}', StoreController::class)
            ->name('admin.store');

        $this->registrar->get('/{resource}/{id}', ShowController::class)
            ->name('admin.show');

        $this->registrar->get('/{resource}/{id}/edit', EditController::class)
            ->name('admin.edit');
        $this->registrar->put('/{resource}/{id}', UpdateController::class)
            ->name('admin.update');

        $this->registrar->get('/{resource}/{id}/delete', DeleteController::class)
            ->name('admin.delete');
        $this->registrar->delete('/{resource}/{id}', DestroyController::class)
            ->name('admin.destroy');
    }

    public function findModel($url)
    {
        if (!isset($this->models[$url]))
            throw new ModelNotFoundException("Model for '$url' not found.");
        return $this->models[$url];
    }

    public function getConfig($model)
    {
        return array_merge([
            'paginate' => 25,
            'query' => function ($query) {
                return $query;
            },
            'pages' => Pages::ALL,
        ], call_user_func([$model, 'getConfig']));
    }
}
