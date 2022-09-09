<?php

namespace Database\Factories;

use App\Models\SuperAdmin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class SuperAdminFactory extends UserFactory
{
     /**
      * Define the model's default state.
      *
      * @return array
      */
    public function definition()
    {
        $definition = parent::definition();
        return array_merge(
            $definition, [
            'type' => 'superadmin'
            ]
        );
    }
}
