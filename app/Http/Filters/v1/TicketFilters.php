<?php

namespace App\Http\Filters\v1;

use Illuminate\Http\Request;

class TicketFilters extends QueryFilter
{
    public function include($value)
    {
        return $this->builder->with($value);
    }
    public function status($value)
    {
        return $this->builder->whereIn('status', explode(',', $value));
    }
    public function title($value)
    {
        return $this->builder->where('title', 'like', "%$value%");
    }
    public function createdAt($value)
    {
        return $this->builder->whereDate('created_at', $value);
    }
}
