<?php

namespace AlexVanVliet\LAP\Controllers;


use AlexVanVliet\LAP\Exceptions\SetupException;
use AlexVanVliet\LAP\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class StoreController extends Controller
{
    use HasValidation;

    public function __invoke(Request $request, $resource)
    {
        $model = $this->panel->findModel($resource);
        $config = $this->panel->getConfig($model);
        if (!($config['pages'] & Pages::CREATE)) {
            return abort(404);
        }

        $rules = $this->getRules($config);
        $this->updateInput($request, $config);

        $data = $this->validate($request, $rules);
        foreach ($config['fields'] as $field) {
            if ($field->readonly()) {
                continue;
            }

            $data[$field->name()]
                = $field->storeValue($data[$field->name()] ?? null);
        }

        $result = call_user_func([$model, 'create'], $data);

        return redirect()
            ->route('admin.show', [$resource, $result]);
    }
}
