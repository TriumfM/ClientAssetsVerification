<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new \App\Client();
        $client->name = 'Client 1';
        $client->iwinback_api_key = 'iWINBACK API KEY';
        $client->iwinback_api_secret = 'iWINBACK API SECRET';
        $client->save();

        $brand = new \App\Brand();
        $brand->name = 'Brand 1';
        $brand->client_id = $client->id;
        $brand->save();

        $campaign = new \App\Campaign();
        $campaign->title = 'Campaign Title';
        $campaign->description = 'Campaign Description';
        $campaign->sms_script = 'Sms Script';
        $campaign->email_html = 'Email Html';
        $campaign->email_subject = 'Email Subject';
        $campaign->call_script = 'Call Script';
        $campaign->brand_id = $brand->id;
        $campaign->save();

        $user = new \App\User();
        $user->first_name = "Admin";
        $user->last_name = "Admini";
        $user->username = "Admin";
        $user->email = "admin@admin.com";
        $user->password = bcrypt("admin");
        $user->active = true;
        $user->save();

        $user->assignRole('super-admin');

    }
}
