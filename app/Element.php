<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Element extends Model {

    protected $fillable = array('name',
                                'description',
                                'context',
                                'class',
                                'step_id',
                                'elementable_id',
                                'elementable_type',
                                'priority_id');

    public function layer() {
        return $this->belongsTo('App\Step');
    }

    public function priority() {
        return $this->belongsTo('App\Priority');
    }

    public function elementable() {
        $this->morphTo();
    }
}
