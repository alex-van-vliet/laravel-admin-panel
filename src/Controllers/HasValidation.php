<?php

namespace AlexVanVliet\LAP\Controllers;

use AlexVanVliet\LAP\Exceptions\SetupException;
use Illuminate\Validation\Rules\Unique;

trait HasValidation
{
    protected function updateInput($request, $config, $update = null)
    {
        $input = $request->input();
        foreach ($input as $key => $value) {
            $field = null;
            foreach ($config['fields'] as $ite) {
                if ($ite->name() === $key) {
                    $field = $ite;
                    break;
                }
            }
            if ($field && is_null($value)) {
                if ($update) {
                    if ($field->removeFromInputIfEmptyOnUpdate()) {
                        unset($input[$key]);
                    }
                } else {
                    if ($field->removeFromInputIfEmptyOnStore()) {
                        unset($input[$key]);
                    }
                }
            }
        }
        $request->replace($input);
    }

    protected function getRules($config, $update = null)
    {
        $allRules = [];
        foreach ($config['fields'] as $field) {
            if ($field->readonly()) {
                continue;
            }
            $rules = $field->rules();
            if (is_null($rules)) {
                throw new SetupException("Missing rules for {$field->name()}.");
            } else {
                if (!is_array($rules)) {
                    throw new SetupException("Use array-style rules for {$field->name()}.");
                }
            }
            if ($update) {
                array_unshift($rules, 'sometimes');

                foreach ($rules as $i => $rule) {
                    if ($rule instanceof Unique) {
                        $rules[$i]->ignore($update->id);
                    }
                }
            }
            $allRules[$field->name()] = $rules;
        }
        return $allRules;
    }
}
