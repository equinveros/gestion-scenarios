<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Texte extends Model
{
    protected $fillable = ['fontSize',
                           'fontFamily'];

    public function element() {
        return $this->morphOne('App\Element', 'elementable');
    }

}
