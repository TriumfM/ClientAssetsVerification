<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}
