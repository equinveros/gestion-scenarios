<?php

use Illuminate\Database\Seeder;

class RectanglesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('rectangles')->insert(['width'      => 745,
                                         'height'     => 109,
                                         'created_at' => now()]);
        DB::table('rectangles')->insert(['width'      => 500,
                                         'height'     => 250,
                                         'created_at' => now()]);
        DB::table('rectangles')->insert(['width'      => 100,
                                         'height'     => 75,
                                         'created_at' => now()]);
        DB::table('rectangles')->insert(['width'      => 90,
                                         'height'     => 330,
                                         'created_at' => now()]);

    }
}
