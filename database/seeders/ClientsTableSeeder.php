<?php

namespace Database\Seeders;

use App\Models\Client;
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
        $clients = ['ahmed', 'mohamed'];

        foreach ($clients as $client) {

            Client::create([
                'name' => $client,
                'phone' => ['011111112'],
                'address' => 'Nasr City',
            ]);
        } //end of foreach

    } //end of run

}//end of seeder
