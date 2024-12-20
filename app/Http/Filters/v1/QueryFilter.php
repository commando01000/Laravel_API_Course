<?php

namespace App\Http\Filters\v1;

use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected $builder;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function filter($arr)
    {
        foreach ($arr as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }
        return $this->builder;
    }

    public function apply($builder)
    {

        $this->builder = $builder;

        foreach ($this->request->all() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }
        return $builder;
    }
}
