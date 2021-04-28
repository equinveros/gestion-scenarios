<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class WelcomeController extends Controller
{
    public function index($lang = false){
        if ($lang) {
            App::setLocale($lang);
        }
        return view("welcome");
    }
}
