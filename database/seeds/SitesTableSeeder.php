<?php

use Illuminate\Database\Seeder;

class SitesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run() {
        DB::table('sites')->insert(['urlSrc'     => 'http://mastereventime.site.calypso-event.net/',
                                    'title'       => 'Master event Time',
                                    'created_at' => now()]);

        DB::table('sites')->insert(['urlSrc'     => 'http://cmxp-exp-bacasable.site.calypso-event.net/',
                                    'title'       => 'Master Comexposium',
                                    'created_at' => now()]);

    }
}
