<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * @var string
     */
    protected $table = "roles";

    /**
     * Revision identifier name
     *
     * @return mixed
     */
    public function identifiableName()
    {
        return $this->name;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
