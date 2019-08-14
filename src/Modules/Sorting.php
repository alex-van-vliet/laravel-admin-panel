<?php

namespace AlexVanVliet\LAP\Modules;

use AlexVanVliet\LAP\AdminController;
use AlexVanVliet\LAP\MissingOptionException;

class Sorting extends Module
{
    protected $keys = [];

    protected $by = [];

    protected $fields = [];

    protected function getKeys($request)
    {
        foreach ($request->getFields() as $field) {
            $key = $field->option('sort_key', false);
            if ($key) {
                $this->keys[$key] = $field->getName();
            }
        }
    }

    protected function parseSort($sort)
    {
        foreach (explode(',', $sort) as $value) {
            if (!preg_match('((.+)_(asc|desc))i', $value, $matches)) {
                continue;
            }
            if (isset($this->fields[$matches[1]])) {
                continue;
            }
            if (!isset($this->keys[$matches[1]])) {
                continue;
            }
            $this->fields[$matches[1]] = count($this->by);
            $this->by[] = [
                'key' => $matches[1],
                'order' => strtolower($matches[2]),
                'name' => $this->keys[$matches[1]],
            ];
        }
    }

    protected function orderQuery($query)
    {
        foreach ($this->by as $order) {
            $query = $query->orderBy($order['name'], $order['order']);
        }
        return $query;
    }

    public function query($request, $query, $next)
    {
        $this->getKeys($request);
        $this->parseSort($request->getRequest()->get('sort', ''));
        return $next($request, $this->orderQuery($query));
    }

    public function queryString($field = null)
    {
        if (is_null($field)) {
            $sortArray = array_map(function ($value) {
                return $value['key'].'_'.$value['order'];
            }, $this->by);

            return implode(',', $sortArray);
        } else {
            $updated = false;
            $name = $field->getName();

            $sortArray = array_filter(array_map(function ($value) use (
                &$updated, &$name
            ) {
                if ($value['name'] === $name) {
                    $updated = true;
                    if ($value['order'] === 'asc') {
                        return $value['key'].'_desc';
                    }
                    return null;
                } else {
                    return $value['key'].'_'.$value['order'];
                }
            }, $this->by), function ($value) {
                return !is_null($value);
            });

            if (!$updated) {
                $key = $field->option('sort_key', false);
                if (!$key) {
                    throw new MissingOptionException('sort_key');
                }

                array_push($sortArray, $key.'_asc');
            }

            return implode(',', $sortArray);
        }
    }

    public function order($field)
    {
        $key = $field->option('sort_key', false);
        if (!$key) {
            throw new MissingOptionException('sort_key');
        }

        if (!isset($this->fields[$key])) {
            return null;
        }

        if (!isset($this->by[$this->fields[$key]])) {
            return null;
        }

        return $this->by[$this->fields[$key]]['order'];
    }

    public function number($field)
    {
        $key = $field->option('sort_key', false);
        if (!$key) {
            throw new MissingOptionException('sort_key');
        }

        if (!isset($this->fields[$key])) {
            return null;
        }

        return $this->fields[$key];
    }
}
