<?php

namespace App\Tenant;


use Illuminate\Database\Eloquent\Model;

class TenantObserver
{
    public function creating(Model $model)
    {
         if (auth()->user()) {
            if(\Auth::user()->getClientId())
                $model->setAttribute('client_id', \Auth::user()->getClientId());
        }
        elseif (request()->has('client_id')) {
            $model->setAttribute('client_id', request('client_id'));
        }

    }

}