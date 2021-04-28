<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->insert(['name'       => 'Admin',
                                    'email'      => 'admin@leni.fr',
                                    'company'      => 'LENI',
                                    'password'   => bcrypt('Admin'),
                                    'admin'      => true,
                                    'created_at' => now()]);
        DB::table('users')->insert(['name'       => 'UserCDP',
                                    'email'      => 'UserCDP@leni.fr',
                                    'company'      => 'LENI',
                                    'password'   => bcrypt('UserCDP'),
                                    'profil_id'  => 1,
                                    'created_at' => now()]);
        DB::table('users')->insert(['name'       => 'UserC',
                                    'email'      => 'UserC@Composium.fr',
                                    'company'      => 'Composium',

                                    'password'   => bcrypt('UserC'),
                                    'profil_id'  => 3,
                                    'created_at' => now()]);
        DB::table('users')->insert(['name'       => 'UserP',
                                    'email'      => 'UserP@leni.fr',
                                    'company'      => 'LENI',
                                    'password'   => bcrypt('UserP'),
                                    'profil_id'  => 2,
                                    'created_at' => now()]);

    }
}
