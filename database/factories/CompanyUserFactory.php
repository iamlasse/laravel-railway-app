<?php

namespace Database\Factories;

use App\Models\CompanyUser;

class CompanyUserFactory extends UserFactory
{
    protected $model = CompanyUser::class;
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
            'type' => 'user'
            ]
        );
    }

    public function withRole($name = 'company-user')
    {
        return $this->afterCreating(
            function (CompanyUser $user) use ($name) {
                $user->assignRole($name);
            }
        );
    }
}
