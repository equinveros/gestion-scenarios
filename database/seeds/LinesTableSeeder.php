<?php

use Illuminate\Database\Seeder;

class LinesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('lines')->insert(['x1'         => 805,
                                    'x2'         => 67,
                                    'y1'         => 297,
                                    'y2'         => 296,
                                    'created_at' => now()]);
        DB::table('lines')->insert(['x1'         => 415,
                                    'x2'         => 418,
                                    'y1'         => 417,
                                    'y2'         => 639,
                                    'created_at' => now()]);
        DB::table('lines')->insert(['x1'         => 40,
                                    'x2'         => 40,
                                    'y1'         => 50,
                                    'y2'         => 150,
                                    'created_at' => now()]);
        DB::table('lines')->insert(['x1'         => 65,
                                    'x2'         => 250,
                                    'y1'         => 80,
                                    'y2'         => 120,
                                    'created_at' => now()]);
        DB::table('lines')->insert(['x1'         => 120,
                                    'x2'         => 80,
                                    'y1'         => 40,
                                    'y2'         => 120,
                                    'created_at' => now()]);

    }
}
