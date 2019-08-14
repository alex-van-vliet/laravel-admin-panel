<?php

namespace AlexVanVliet\LAP\Requests;

use Illuminate\Http\Request;

class Index
{
    use HasModules;
    use HasFetchMethod;
    use HasModel;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request = null;

    /**
     * Index constructor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $model
     * @param  array  $fields
     * @param  array  $modules
     */
    public function __construct(Request $request, string $model, array $fields,
                                array $modules)
    {
        $this->request = $request;
        $this->setupModel($model, $fields);
        $this->setupModules($modules);
    }

    protected function query($query)
    {
        $i = 0;
        $next = function ($request, $query) use (&$i, &$next) {
            if ($i === count($request->getModules())) {
                return $query;
            }
            return $request->getModule($i++)->query($request, $query, $next);
        };
        return $next($this, $query);
    }

    protected function handle($results)
    {
        $i = 0;
        $next = function ($request, $results) use (&$i, &$next) {
            if ($i === count($request->getModules())) {
                return $results;
            }
            return $request->getModule($i++)->handle($request, $results, $next);
        };
        return $next($this, $results);
    }

    /**
     * @return mixed
     */
    public function render($query)
    {
        $query = $this->query($query);
        $results = $this->getFetchMethod()($query);
        return $this->handle($results);
    }

    public function getRequest()
    {
        return $this->request;
    }
}
