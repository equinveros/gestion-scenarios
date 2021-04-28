<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rectangle extends Model {
    protected $fillable = ['width',
                           'height'];


    public function element() {
        return $this->morphOne('App\Element', 'elementable');
    }



}
