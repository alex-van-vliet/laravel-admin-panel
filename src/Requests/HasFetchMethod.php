<?php

namespace AlexVanVliet\LAP\Requests;


trait HasFetchMethod
{
    /**
     * @var Callable
     */
    protected $fetchMethod = null;

    /**
     * @param  Callable  $fetchMethod
     */
    public function setFetchMethod($fetchMethod): void
    {
        $this->fetchMethod = $fetchMethod;
    }

    /**
     * @return Callable
     */
    public function getFetchMethod()
    {
        return $this->fetchMethod ?? function ($query) {
                return $query->get();
            };
    }


}
