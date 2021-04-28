<?php

use Illuminate\Database\Seeder;

class ElementsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('elements')->insert(['name'             => 'Element 1',
                                       'context'          => 'Context Element 1',
                                       'description'      => 'Description Element 1',
                                       'step_id'         => 1,
                                       'priority'         => 1,
                                       'pos_x'            => -13,
                                       'pos_y'            => 216,
                                       'state'            => "ok",
                                       'elementable_id'   => 1,
                                       'elementable_type' => "Line",
                                       'created_at'       => now()]);


        DB::table('elements')->insert(['name'             => 'Element 2',
                                       'context'          => 'Context Element 2',
                                       'description'      => 'Description Element 2',
                                       'step_id'         => 1,
                                       'priority'         => 2,
                                       'pos_x'            => 64,
                                       'pos_y'            => 303,
                                       'state'            => "inProgress",
                                       'elementable_id'   => 1,
                                       'elementable_type' => "Rectangle",
                                       'created_at'       => now()]);

        DB::table('elements')->insert(['name'             => 'Element 3',
                                       'context'          => 'Context Element 3',
                                       'description'      => 'Description Element 3',
                                       'step_id'         => 1,
                                       'priority'         => 3,
                                       'pos_x'            => 15,
                                       'pos_y'            => 183,
                                       'elementable_id'   => 2,
                                       'elementable_type' => "Line",
                                       'created_at'       => now()]);

        DB::table('elements')->insert(['name'             => 'Element 4',
                                       'context'          => 'Context Element 4',
                                       'description'      => 'Description Element 4',
                                       'step_id'         => 1,
                                       'priority'         => 1,
                                       'pos_x'            => 150,
                                       'pos_y'            => 80,
                                       'state'            => "ok",
                                       'elementable_id'   => 1,
                                       'elementable_type' => "Text",
                                       'created_at'       => now()]);

        DB::table('elements')->insert(['name'             => 'Element 5',
                                       'context'          => 'Context Element 5',
                                       'description'      => 'Description Element 5',
                                       'step_id'         => 1,
                                       'priority'         => 1,
                                       'pos_x'            => 130,
                                       'pos_y'            => 530,
                                       'state'            => "ko",
                                       'elementable_id'   => 2,
                                       'elementable_type' => "Text",
                                       'created_at'       => now()]);

        DB::table('elements')->insert(['name'             => 'Element 4',
                                       'context'          => 'Context Element 1',
                                       'description'      => 'Description Element 1',
                                       'step_id'         => 2,
                                       'priority'         => 1,
                                       'pos_x'            => 20,
                                       'pos_y'            => 50,
                                       'elementable_id'   => 2,
                                       'elementable_type' => "Rectangle",
                                       'created_at'       => now()]);

        DB::table('elements')->insert(['name'             => 'Element 5',
                                       'context'          => 'Context Element 5',
                                       'description'      => 'Description Element 5',
                                       'step_id'         => 2,
                                       'priority'         => 2,
                                       'pos_x'            => 130,
                                       'pos_y'            => 40,
                                       'elementable_id'   => 3,
                                       'elementable_type' => "Line",
                                       'created_at'       => now()]);
        DB::table('elements')->insert(['name'             => 'Element 6',
                                       'context'          => 'Context Element 6',
                                       'description'      => 'Description Element 6',
                                       'step_id'         => 2,
                                       'priority'         => 3,
                                       'pos_x'            => 70,
                                       'pos_y'            => 180,
                                       'elementable_id'   => 3,
                                       'elementable_type' => "Rectangle",
                                       'created_at'       => now()]);
        DB::table('elements')->insert(['name'             => 'Element 7',
                                       'context'          => 'Context Element 7',
                                       'description'      => 'Description Element 7',
                                       'step_id'         => 3,
                                       'priority'         => 1,
                                       'pos_x'            => 110,
                                       'pos_y'            => 30,
                                       'elementable_id'   => 4,
                                       'elementable_type' => "Line",
                                       'created_at'       => now()]);
        DB::table('elements')->insert(['name'             => 'Element 8',
                                       'context'          => 'Context Element 8',
                                       'description'      => 'Description Element 8',
                                       'step_id'         => 3,
                                       'priority'         => 2,
                                       'pos_x'            => 80,
                                       'pos_y'            => 190,
                                       'elementable_id'   => 4,
                                       'elementable_type' => "Rectangle",
                                       'created_at'       => now()]);
        DB::table('elements')->insert(['name'             => 'Element 9',
                                       'context'          => 'Context Element 9',
                                       'description'      => 'Description Element 9',
                                       'step_id'         => 3,
                                       'priority'         => 3,
                                       'pos_x'            => 130,
                                       'pos_y'            => 150,
                                       'elementable_id'   => 5,
                                       'elementable_type' => "Line",
                                       'created_at'       => now()]);
    }
}
