<?php

namespace AlexVanVliet\LAP\Requests;

use AlexVanVliet\LAP\Modules\Module;

trait HasModules
{
    /**
     * @var array
     */
    protected $modules = [];

    /**
     * @var array
     */
    protected $modulesOrder = [];

    /**
     * @param  array  $modules
     */
    protected function setupModules(array $modules): void
    {
        foreach ($modules as $module) {
            if (is_array($module)) {
                $this->modules[$module[0]]
                    = new $module[0](...($module[1] ?? []));
                $this->modulesOrder[] = $module[0];
            } else {
                $this->modules[$module] = new $module();
                $this->modulesOrder[] = $module;
            }
        }
    }

    /**
     * @return array
     */
    public function getModules(): array
    {
        return $this->modules;
    }

    /**
     * @param $i
     *
     * @return \AlexVanVliet\LAP\Modules\Module
     */
    public function getModule($i): Module
    {
        if (is_string($i)) {
            return $this->modules[$i] ?? null;
        }
        return $this->modules[$this->modulesOrder[$i]] ?? null;
    }

    public function hasModule($i): bool
    {
        return !is_null($this->getModule($i));
    }
}
