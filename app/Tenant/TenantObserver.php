<?php

namespace App\Tenant;


use Illuminate\Database\Eloquent\Model;

class TenantObserver
{
    public function creating(Model $model)
    {
        if (request()->has('client_id')) {
            $model->setAttribute('client_id', request('client_id'));
        }
        else {
            $model->setAttribute('client_id', \Auth::user()->getClientId());
        }
    }

}