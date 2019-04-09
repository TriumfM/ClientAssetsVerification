<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
class RoleTableSeeder extends Seeder
{
    public function run()
    {
        $query = "SELECT *
                  FROM oauth_clients";

        if(!(\DB::select($query))) {
            Artisan::call("passport:install");
        }

        $role1 = new Role();
        $role1->name = 'super admin';
        $role1->save();

        $role2 = new Role();
        $role2->name = 'client admin';
        $role2->save();

        $role3 = new Role();
        $role3->name = 'client user';
        $role3->save();

        $role4 = new Role();
        $role4->name = 'client viewer';
        $role4->save();
    }

}
