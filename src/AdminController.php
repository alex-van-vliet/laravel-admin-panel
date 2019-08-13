<?php

namespace AlexVanVliet\LAP;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    protected static $paginateBy = 25;

    protected function query()
    {
        return call_user_func_array([static::$model, 'query'], []);
    }

    protected function results()
    {
        $query = $this->query();

        if (static::$paginateBy) {
            return $query->paginate(self::$paginateBy);
        }

        return $query->get();
    }

    protected function index_title()
    {
        return Str::plural(static::$title);
    }

    protected function urls(Request $request)
    {
        $router = &$this->router;
        $start = substr($request->route()->getName(), 0,
            strrpos($request->route()->getName(), '.') + 1);
        return collect([
            'index',
            'show',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ])->map(function ($value) use (&$start) {
            return $start.$value;
        })->filter(function ($route) use (&$router) {
            return $router->has($route);
        })->toArray();
    }

    public function index(Request $request)
    {
        return view('lap::index')
            ->with('results', $this->results())
            ->with('paginated', !!self::$paginateBy)
            ->with('title', $this->index_title())
            ->with('urls', $this->urls($request));
    }
}
