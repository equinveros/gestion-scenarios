<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model {

    protected $fillable = ['urlSrc',
                           'title'];

    public function pages() {
        return $this->hasMany('App\Page');
    }

    public function scenarios() {
        return $this->hasMany('App\Scenario');
    }
}
