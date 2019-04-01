<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaign';

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function client()
    {
        return $this->hasOneThrough(Client::class, Brand::class);
    }
}
