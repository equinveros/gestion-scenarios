<?php

use Illuminate\Database\Seeder;

class StepsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('steps')->insert(['name' => 'Accueil',
                                    'description' => 'Accueil - Master',
                                    'scenario_id' => 1,
                                    //'priority_id' => 1,
                                    'step_number' => 1,
                                    'page_id' => 1,
                                    'created_at' => now()]);
        DB::table('steps')->insert(['name' => 'Information Pratique',
                                    'description' => 'Information Pratique',
                                    'scenario_id' => 1,
                                    //'priority_id' => 3,
                                    'step_number' => 2,
                                    'page_id' => 2,
                                    'created_at' => now()]);
        DB::table('steps')->insert(['name' => 'Accueil',
                                    'description' => 'Accueil - Comexposium',
                                    'scenario_id' => 2,
                                    //'priority_id' => 3,
                                    'step_number' => 1,
                                    'page_id' => 14,
                                    'created_at' => now()]);
        DB::table('steps')->insert(['name' => 'Espace exposant',
                                    'description' => 'Espace Exposant',
                                    'scenario_id' => 2,
                                    //'priority_id' => 2,
                                    'step_number' => 2,
                                    'page_id' => 15,
                                    'created_at' => now()]);
        DB::table('steps')->insert(['name' => 'Le programme',
                                    'description' => 'Le programme',
                                    'scenario_id' => 4,
                                    //'priority_id' => 2,
                                    'step_number' => 1,
                                    'page_id' => 3,
                                    'created_at' => now()]);
        DB::table('steps')->insert(['name' => 'Informations pratique',
                                    'description' => 'Informations pratique',
                                    'scenario_id' => 4,
                                    //'priority_id' => 3,
                                    'step_number' => 2,
                                    'page_id' => 2,
                                    'created_at' => now()]);
    }

}
