<?php

namespace App\Models;

use App\Http\Filters\v1\QueryFilter;
use App\Http\Filters\v1\TicketFilters;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeFilter(Builder $query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
