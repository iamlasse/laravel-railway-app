<?php

namespace Database\Factories;

use App\Models\Admin;

class AdminFactory extends UserFactory
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
            'type' => 'admin'
            ]
        );
    }
}
