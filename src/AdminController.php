<?php

declare(strict_types=1);

namespace AlexVanVliet\LAP;

use AlexVanVliet\LAP\Requests\Index;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var string
     */
    protected $model = null;

    /**
     * @var array
     */
    protected $fields = null;

    /**
     * @var array
     */
    protected $modules = null;

    /**
     * AdminController constructor.
     *
     * @throws \AlexVanVliet\LAP\MissingOptionException
     */
    public function __construct()
    {
        if (is_null($this->model)) {
            throw new MissingOptionException('model');
        }
        if (is_null($this->fields)) {
            throw new MissingOptionException('fields');
        }
        if (is_null($this->modules)) {
            throw new MissingOptionException('modules');
        }

        foreach ($this->fields as $name => $options) {
            $this->fields[$name] = new Field($name, $options);
        }
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $adminRequest = new Index($request, $this->model, $this->fields,
            $this->modules['index']);
        return $adminRequest->render();
    }
}
