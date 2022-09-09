<?php

namespace App\Models\Concerns;

use App\Scopes\TenantScope;

trait BelongsToCompany
{
    public static function bootedBelongsToCompany()
    {
        static::addGlobalScope(new TenantScope());
    }
}
