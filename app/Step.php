<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model {

    protected $fillable = ['name',
                           'description',
                           'scenario_id',
                           'priority_id',
                           'page_id'];

    public function elements() {
        return $this->hasMany('App\Element');
    }

    public function scenario() {
        return $this->belongsTo('App\Scenario');
    }

    public function priority() {
        return $this->belongsTo('App\Priority');
    }

    public function page() {
        return $this->belongsTo('App\Page');
    }


}
