<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;

class Admin extends User
{
    use HasFactory;
    use HasParent;

    public function scopeActive(Builder $query)
    {
        return $query;
    }
}
