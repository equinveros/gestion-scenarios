<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model {
    protected $fillable = ['x1',
                           'x2',
                           'y1',
                           'y2'];

    public function element() {
        return $this->morphOne('App\Element', 'elementable');
    }
}
