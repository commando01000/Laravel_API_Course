<?php

namespace App\Http\Filters\v1;

class UserFilters extends QueryFilter
{
    public function include($value)
    {
        return $this->builder->with($value);
    }
    public function id($value)
    {
        return $this->builder->whereIn('id', explode(',', $value));
    }
    public function email($value)
    {
        return $this->builder->where('email', 'like', "%$value%");
    }
    public function name($value)
    {
        return $this->builder->where('name', 'like', "%$value%");
    }
    public function createdAt($value)
    {
        return $this->builder->whereDate('created_at', $value);
    }
    public function updatedAt($value)
    {
        return $this->builder->whereDate('updated_at', $value);
    }
}
