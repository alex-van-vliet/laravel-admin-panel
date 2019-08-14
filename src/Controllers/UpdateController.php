<?php

namespace AlexVanVliet\LAP\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UpdateController extends Controller
{
    public function getRules($config)
    {
        $rules = [];
        foreach ($config['fields'] as $field) {
            if ($field->readonly()) {
                continue;
            }
            $rules[$field->name()] = $field->rules();
        }
        return $rules;
    }

    public function __invoke(Request $request, $resource, $id)
    {
        $model = $this->panel->findModel($resource);
        $config = $this->panel->getConfig($model);

        $query = $config['query'](call_user_func([$model, 'query']));
        $result = $query->findOrFail($id);

        $rules = $this->getRules($config);

        $data = $this->validate($request, $rules);

        foreach ($config['fields'] as $field) {
            if ($field->readonly()) {
                continue;
            }

            $data[$field->name()]
                = $field->updateValue($data[$field->name()] ?? null);
        }

        $result->fill($data);
        $result->save();

        return redirect()
            ->route('admin.show', [$resource, $result]);
    }
}
