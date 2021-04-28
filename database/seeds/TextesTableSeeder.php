<?php

use Illuminate\Database\Seeder;

class TextesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('textes')->insert(['created_at' => now()]);
        DB::table('textes')->insert(['created_at' => now()]);
    }
}
