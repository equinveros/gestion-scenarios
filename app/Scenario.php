<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scenario extends Model {

    protected $fillable = ['name',
                           'descirption',
                           'context',
                           'priority_id',
                           'state_id',
                           'site_id'];

    public function layer() {
        return $this->hasMany('App\Step');
    }

    public function priority() {
        return $this->belongsTo('App\Priority');
    }

    public function state() {
        return $this->belongsTo('App\State');
    }

    public function site() {
        return $this->belongsTo('App\Site');
    }

}
