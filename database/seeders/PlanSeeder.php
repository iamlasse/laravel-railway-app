<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(config('telekom.operators'))->each(function ($operator) {
            switch ($operator['id']) {
                    // Telia
                case 1:
                    Plan::factory(5)->state(new Sequence(
                      
                        [
                            'name' => 'Telia Företag 0Gb',
                            'data' => 500,
                            'price' => 499,
                        ],
                        [

                            'name' => 'Telia Företag 3Gb',
                            'data' => 3,
                            'price' => 499,
                        ],
                        [

                            'name' => 'Telia Företag 15Gb',
                            'data' => 15,
                            'price' => 499,
                        ],
                        [

                            'name' => 'Telia Företag 40Gb',
                            'data' => 40,
                            'price' => 499,
                        ],
                        [
                            'name' => 'Telia Växel Användare',
                            'data' => 0,
                            'price' => 99,
                            'is_vaxel_plan' => true
                        ],
                    ))->create([
                        'operator_id' => $operator['id']
                    ]);
                    break;
                    // Tele2
                case 2:
                    Plan::factory(5)->state(new Sequence(
                        [
                            'name' => 'Tele2 Företag 0Gb',
                            'data' => 500,
                            'price' => 499,
                        ],
                        [

                            'name' => 'Tele2 Företag 50Gb',
                            'data' => 50,
                            'price' => 499,
                        ],
                        [

                            'name' => 'Tele2 Företag 15Gb',
                            'data' => 15,
                            'price' => 399,
                        ],
                        [

                            'name' => 'Tele2 Företag 3Gb',
                            'data' => 3,
                            'price' => 339,
                        ],
                        [

                            'name' => 'Tele2 Växel Användare',
                            'data' => 0,
                            'price' => 99,
                            'is_vaxel_plan' => true
                        ]
                    ))->create([
                        'operator_id' => $operator['id']
                    ]);
                    break;
                    // Tre
                case 3:
                    Plan::factory(3)->state(new Sequence(
                        [
                            'name' => 'Tre Företag 0Gb',
                            'data' => 500,
                            'price' => 249,
                        ],
                        [

                            'name' => 'Tre Företag 5Gb',
                            'data' => 5,
                            'price' => 229,
                        ],
                        [

                            'name' => 'Tre Växel Användare',
                            'data' => 0,
                            'price' => 89,
                            'is_vaxel_plan' => true
                        ],
                    ))->create([
                        'operator_id' => $operator['id']
                    ]);
                    break;
                    // Telenor
                case 4:
                    Plan::factory(5)->state(new Sequence(
                        [
                            'name' => 'Telenor Företag 0Gb',
                            'data' => 500,
                            'price' => 349,
                        ],
                        [

                            'name' => 'Telenor Företag 50Gb',
                            'data' => 50,
                            'price' => 319,
                        ],
                        [

                            'name' => 'Telenor Företag 15Gb',
                            'data' => 15,
                            'price' => 299,
                        ],
                        [

                            'name' => 'Telenor Företag 5Gb',
                            'data' => 5,
                            'price' => 239,
                        ],
                        [

                            'name' => 'Telenor Växel Användare',
                            'data' => 0,
                            'price' => 99,
                            'is_vaxel_plan' => true
                        ],
                    ))->create([
                        'operator_id' => $operator['id']
                    ]);
                    break;
                    // Soluno
                case 5:
                    Plan::factory(4)->state(new Sequence(
                        [
                            'name' => 'Soluno Företag 0Gb',
                            'data' => 500,
                            'price' => 499,
                        ],
                        [

                            'name' => 'Soluno Företag 30Gb',
                            'data' => 30,
                            'price' => 389,
                        ],
                        [

                            'name' => 'Soluno Företag 10Gb',
                            'data' => 10,
                            'price' => 259,
                        ],
                        [

                            'name' => 'Soluno Växel Användare',
                            'data' => 0,
                            'price' => 99,
                            'is_vaxel_plan' => true
                        ]
                    ))->create([
                        'operator_id' => $operator['id']
                    ]);
                    break;
            }
        });
    }
}
