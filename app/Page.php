<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    protected $fillable = ['url',
                           'site_id'];

    public function site() {
        return $this->belongsTo('App\Site');
    }
}
