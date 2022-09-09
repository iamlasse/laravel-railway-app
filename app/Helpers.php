<?php

// Helpers

use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

if (!function_exists('company')) {
    function company($id = null)
    {
        if (
            is_null($id)
            && Auth::check()
            && (auth()->user() instanceof CompanyUser
                || auth()->user()->hasRole('company-admin'))
        ) {
            return auth()->user()->company;
        }

        return Company::findOrFail($id);
    }
}

if (!function_exists('operators')) {
    function operators()
    {
        return Cache::rememberForever(
            'operators',
            function () {
                return collect(config('telekom.operators'));
            }
        );
    }
}

if (!function_exists('plans')) {
    function plans(int $operatorId)
    {
        return Cache::rememberForever(
            $operatorId . '-plans',
            function () use ($operatorId) {
                return Plan::whereOperatorId($operatorId)->get(['id', 'name', 'data']);
            }
        );
    }
}

if (!function_exists('toGB')) {
    function toGB($amount = null)
    {
        if (is_null($amount)) {
            return 0;
        }
        return ($amount / 1000);
    }
}

if (!function_exists('stepLabels')) {
    function stepLabels()
    {
        return [
            1 => '1. Översikt',
            2 => '2. Insikter & trender',
            3 => '3. Optimerade prisförslag',
            4 => '4. Beställ abonnemang',
            5 => '5. Klart',
        ];
    }
}
if (!function_exists('selected_operator_or_order')) {
    function selected_operator_or_order(): bool
    {
        return company()->hasSelectedOperator() || company()->orderInProgress();
    }
}

function selected_operator()
{
    if (session('selected_operator')) {
        return operators()->firstWHere('id', session('selected_operator'));
    }
}
