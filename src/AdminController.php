<?php

namespace AlexVanVliet\LAP;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getModel() {
        if (!property_exists(static::class, 'model'))
            throw new MissingOptionException('model');
        return $this->model;
    }

    public function getFields() {
        if (!property_exists(static::class, 'fields')) {
            throw new MissingOptionException('fields');
        }
        return $this->fields;
    }

    public function index(Request $request)
    {
        $query = call_user_func_array([$this->getModel(), 'query'], []);
        $currentModule = 0;
        $modules = [];
        $modulesOrder = [];
        foreach (static::$modules['index'] as $module) {
            if (is_array($module)) {
                $modules[$module[0]] = new $module[0]($this, ...($module[1] ?? []));
                $modulesOrder[] = $module[0];
            } else {
                $modules[$module] = new $module($this);
                $modulesOrder[] = $module;
            }
        }
        $next = function ($query) use (
            &$currentModule, &$modules, &$modulesOrder, &$next
        ) {
            if ($currentModule !== count($modulesOrder)) {
                return $modules[$modulesOrder[$currentModule++]]->query($query,
                    $next);
            }
            return $query;
        };
        $results = $next($query);
        $currentModule = 0;
        $next = function ($results) use (
            &$currentModule, &$modules, &$modulesOrder, &$next
        ) {
            if ($currentModule !== count($modulesOrder)) {
                return $modules[$modulesOrder[$currentModule++]]->handle($results,
                    $next);
            }
            return $results;
        };
        return $next($results);
    }
}
