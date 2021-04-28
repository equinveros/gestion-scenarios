<?php

use Illuminate\Database\Seeder;

class ScenariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('scenarios')->insert(['name' => 'Scénario 1',
            'description' => 'Description Scénario 1',
            'context' => 'Context Scénario 1',
            'user_create_id' => 1,
            'priority' => 2,
            'state' => 1,
            'created_at' => now()]);
        DB::table('scenarios')->insert(['name' => 'Scénario 2',
            'description' => 'Description Scénario 2',
            'context' => 'Context Scénario 2',
            'user_create_id' => 1,
            'site_id' => 2,
            'priority' => 1,
            'state' => 1,
            'created_at' => now()]);
        DB::table('scenarios')->insert(['name' => 'Scénario 3',
            'description' => 'Description Scénario 3',
            'context' => 'Context Scénario 3',
            'state' => 2,
            'site_id' => 2,
            'priority' => 3,
            'user_create_id' => 3,
            'created_at' => now()]);
        DB::table('scenarios')->insert(['name' => 'Scénario 4',
            'description' => 'Description Scénario 4',
            'context' => 'Context Scénario 4',
            'state' => 3,
            'priority' => 1,
            'user_create_id' => 2,
            'created_at' => now()]);

    }
}
