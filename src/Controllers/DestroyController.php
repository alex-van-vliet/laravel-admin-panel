<?php

namespace AlexVanVliet\LAP\Controllers;


use AlexVanVliet\LAP\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DestroyController extends Controller
{
    public function __invoke(Request $request, $resource, $id)
    {
        $model = $this->panel->findModel($resource);
        $config = $this->panel->getConfig($model);
        if (!($config['pages'] & Pages::DELETE)) {
            return abort(404);
        }

        $query = $config['query'](call_user_func([$model, 'query']));
        $result = $query->findOrFail($id);

        $result->delete();

        return redirect()
            ->route('admin.index', [$resource]);
    }
}
