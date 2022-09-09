<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\SuperAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super = SuperAdmin::factory()->create(
            [
            'name' => "Lasse Larsen",
            'username' => 'lasse.larsen',
            'email' => 'iamlasse@gmail.com',
            'phone' => '0708194445'
            ]
        );


        $admin1 = Admin::factory()->create(
            [
            'name' => 'Daniel Tegner',
            'username' => 'daniel.tegner',
            'email' => 'daniel@telekom-kollen.se',
            'phone' => '0708194445'
            ]
        );

        // $admin1->givePermissionTo('manage-company');
        
        $admin2 = Admin::factory()->create(
            [
            'name' => 'Fredrik Dolk',
            'username' => 'fredrik.dolk',
            'email' => 'fredrik@telekom-kollen.se',
            'phone' => '0708194445'
            ]
        );

        $super->assignRole('super-admin');
        $admin1->assignRole('company-admin');
        $admin2->assignRole('company-admin');
    }
}
