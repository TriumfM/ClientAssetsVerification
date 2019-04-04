<?php

namespace App\Tenant;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if(auth()->user())
            return $builder->where('client_id', '=', \Auth::user()->getClientId());
        else if(request()->has('client_id')){
            return $builder->where('client_id', '=', request('client_id'));
        }
        return $builder;
    }
}