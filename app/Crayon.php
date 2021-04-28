<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crayon extends Model
{
    protected $fillable = ['points'];

    public function element() {
        return $this->morphOne('App\Element', 'elementable');
    }

}
