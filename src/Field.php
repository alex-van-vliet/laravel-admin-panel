<?php

declare(strict_types=1);

namespace AlexVanVliet\LAP;


use Illuminate\Support\Str;

class Field
{
    protected $name;
    protected $type;
    protected $options;

    /**
     * Field constructor.
     *
     * @param $name
     * @param $options
     */
    public function __construct($name, $options)
    {
        $this->name = $name;
        $this->type = Str::lower($options['type']);
        unset($options['type']);
        $this->options = $options;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function displayName()
    {
        return $this->options['display_name'] ?? Str::ucfirst($this->name);
    }

    public function value($result)
    {
        switch ($this->type) {
            case 'password':
                return '********';
            case 'boolean':
                return $result->{$this->name} ? 'Yes' : 'No';
            default:
                return $result->{$this->name};
        }
    }

    public function option($name, $default)
    {
        return $this->options[$name] ?? $default;
    }
}