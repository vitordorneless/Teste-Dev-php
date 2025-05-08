<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Clients;
use Carbon\Carbon;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'full_name'=>'Vítor Dorneles',
                'doc_number'=>'00729530043',
                'email'=>'vitor@gmail.com',
                'phone'=>'5551994336363',
                'address'=>'professor clemente pinto, 283',
                'district'=>'Medianeira',
                'city'=>'Porto Alegre',
                'state'=>'RS',
                'zip_code'=>'91790-000',
                'created_at' => Carbon::now()
            ],
            [
                'full_name'=>'Marja Tatiane',
                'doc_number'=>'02223978029',
                'email'=>'marja@gmail.com',
                'phone'=>'5551994336363',
                'address'=>'professor clemente pinto, 284',
                'district'=>'Medianeira',
                'city'=>'Porto Alegre',
                'state'=>'RS',
                'zip_code'=>'91790-000',
                'created_at' => Carbon::now()
            ]
        ];

        // Looping and Inserting Array's Users into User Table
        foreach($clients as $client){
            Clients::create($client);
        }
    }
}
