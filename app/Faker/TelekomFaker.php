<?php

namespace App\Faker;

use Faker\Provider\Base;

class TelekomFaker extends Base
{
    protected static $departments = [
        'HR',
        'Försäljning',
        'Kund Support',
        'Utveckling',
        'Styrelse'
    ];

    public function department(): string
    {
        return static::randomElement(static::$departments);
    }
}
