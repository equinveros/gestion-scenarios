<?php

use Illuminate\Database\Seeder;

class ProfilsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('profils')->insert(['name'      => 'Chef de projet',
                                    'created_at' => now()]);
        DB::table('profils')->insert(['name'      => 'Paramètreur',
                                    'created_at' => now()]);
        DB::table('profils')->insert(['name'      => 'Client',
                                    'created_at' => now()]);
    }
}
