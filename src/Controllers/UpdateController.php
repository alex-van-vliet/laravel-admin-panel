<?php

namespace AlexVanVliet\LAP\Controllers;


use AlexVanVliet\LAP\Exceptions\SetupException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class UpdateController extends Controller
{
    use HasValidation;

    public function __invoke(Request $request, $resource, $id)
    {
        $model = $this->panel->findModel($resource);
        $config = $this->panel->getConfig($model);

        $query = $config['query'](call_user_func([$model, 'query']));
        $result = $query->findOrFail($id);

        $rules = $this->getRules($config, $result);
        $this->updateInput($request, $config);

        $data = $this->validate($request, $rules);
        foreach ($config['fields'] as $field) {
            if ($field->readonly()) {
                continue;
            }

            $data[$field->name()]
                = $field->updateValue($result->{$field->name()},
                $data[$field->name()] ?? null);
        }

        $result->fill($data);
        $result->save();

        return redirect()
            ->route('admin.show', [$resource, $result]);
    }
}
