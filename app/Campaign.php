<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaigns';

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function client()
    {
        return $this->hasOneThrough(Client::class, Brand::class, 'id', 'id');
    }

    public function getClientIdAttribute()
    {
        return $this->client->id;
    }
}
