<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * @var string
     */
    protected $table = 'clients';

    /**
     * @var array
     */
    protected $hidden = ['iwinback_api_key', 'iwinback_api_secret'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function brands()
    {
        return $this->hasMany(Brand::class);
    }
}
