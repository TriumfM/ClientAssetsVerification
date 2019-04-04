<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleTableSeeder extends Seeder
{
    public function run()
    {
        $query = "SELECT *
                  FROM oauth_clients";

        if(!(\DB::select($query))) {
            Artisan::call("passport:install");
        }

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit campaigns']);
        Permission::create(['name' => 'delete campaigns']);
        Permission::create(['name' => 'view campaigns']);
        Permission::create(['name' => 'disapprove campaigns']);

        Permission::create(['name' => 'edit assets']);
        Permission::create(['name' => 'verify assets']);
        Permission::create(['name' => 'view assets']);

        Permission::create(['name' => 'create client viewers']);
        Permission::create(['name' => 'create client user']);

        Permission::create(['name' => 'edit clients']);
        Permission::create(['name' => 'delete clients']);


        // create roles and assign created permissions

        $role = Role::create(['name' => 'client-viewer']);
        $role->givePermissionTo('view assets');

        $role = Role::create(['name' => 'client-user']);
        $role->givePermissionTo(['edit assets', 'verify assets', 'view assets']);

        $role = Role::create(['name' => 'client-admin'])
            ->givePermissionTo([
                'edit assets', 'verify assets', 'view assets',
                'edit campaigns', 'view campaigns', 'disapprove campaigns', 'delete campaigns'
            ] );

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }

}
