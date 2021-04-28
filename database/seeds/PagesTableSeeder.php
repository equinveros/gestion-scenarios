<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('pages')->insert(['url'        => '/',
                                    'site_id'    => 1,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/accueil/vous_aider/informations_pratiques.htm',
                                    'site_id'    => 1,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/accueil/vous_aider/le_programme.htm',
                                    'site_id'    => 1,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/espace-congressiste.htm',
                                    'site_id'    => 1,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/inscription.htm',
                                    'site_id'    => 1,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/inscription/etape-2-participation.htm',
                                    'site_id'    => 1,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/inscription/etape-3-conferences.htm',
                                    'site_id'    => 1,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/inscription/etape-4-justificatifs.htm',
                                    'site_id'    => 1,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/inscription/etape-5-recapitulatif.htm',
                                    'site_id'    => 1,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/inscription/fin.htm',
                                    'site_id'    => 1,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/inscription/recapitulatif/paiement.htm',
                                    'site_id'    => 1,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/inscription/impression_recapitulatif.htm',
                                    'site_id'    => 1,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/inscription/votre-inscription.htm',
                                    'site_id'    => 1,
                                    'created_at' => now()]);

        DB::table('pages')->insert(['url'        => '/',
                                    'site_id'    => 2,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/espace-exposant.htm',
                                    'site_id'    => 2,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/espace-exposant/coordonnees-individu.htm',
                                    'site_id'    => 2,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/espace-exposant/demande-de-contact.htm',
                                    'site_id'    => 2,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/espace-exposant/demande-de-contact/confirmation.htm',
                                    'site_id'    => 2,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/espace-exposant/extranet-exposant.htm',
                                    'site_id'    => 2,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/espace-exposant/extranet-exposant/fermeture-temporaire.htm',
                                    'site_id'    => 2,
                                    'created_at' => now()]);
        DB::table('pages')->insert(['url'        => '/espace-exposant/extranet-exposant/dossier-en-attente-de-validation.htm',
                                    'site_id'    => 2,
                                    'created_at' => now()]);


    }
}
