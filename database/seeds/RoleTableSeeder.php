<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name  = 'Super Admin';
        $role->save();

        $role2 = new Role();
        $role2->name  = 'Client Admin';
        $role2->save();

        $role3 = new Role();
        $role3->name  = 'Client User';
        $role3->save();

        $role4 = new Role();
        $role4->name  = 'Client Viewer';
        $role4->save();
    }
}
