<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call(SitesTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(ProfilsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ScenariosTableSeeder::class);
        $this->call(StepsTableSeeder::class);
        $this->call(ElementsTableSeeder::class);
        $this->call(RectanglesTableSeeder::class);
        $this->call(LinesTableSeeder::class);
        $this->call(TextesTableSeeder::class);
    }
}
