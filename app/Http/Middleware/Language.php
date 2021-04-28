<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Language
{
    public function handle($request, Closure $next)
    {
        $segment_1 = $request->segment(1);

        $arr_languages = config('app.languages');
        //la page d'accueil sans choix de langue
        if(is_null($segment_1) && is_null(Session::get('applocale')) ){
            //Comme aucune langue n'est definie on prend celle par défault
            $fallback_locale = config('app.fallback_locale');
            Session::put('applocale', $fallback_locale);
            Session::put('lang_name', $arr_languages[$fallback_locale]);
        }
        //Le segment correspond a une des langues que l'on a
        if(isset($arr_languages[$segment_1])){
            //Si la langue de l'url n'est pas celle de la session, on la change
            if($segment_1 !=Session::get('applocale')){
                Session::put('applocale', $segment_1);
                Session::put('lang_name', $arr_languages[$segment_1]);
            }
        }
        //si c'est la home, on redirige avec la langue a la fin
        if(is_null($segment_1)){
            return redirect(url('/')."/".Session::get('applocale')."/");
        }
        //On set la langue pour les fichier de trad
        App::setLocale(Session::get('applocale'));

        return $next($request);
    }
}
