<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
use DB;
use Faker\Factory;

class UserTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facker = Factory::create();

        User::create([
            'name'       => 'Admin',
            'email'      => 'admin@gmail.com',
            'password'   => Hash::make('123456789'),
        ]);

        foreach(range(1, 25) as $item){

        User::create([
            'name'       => $facker->name,
            'email'      => $facker->unique()->email,
            'password'   => Hash::make('123456789'),
           ]);

        }


        DB::table('oauth_clients')->insert([ 
            "user_id"                  =>null,
            "name"                     =>"Laravel Personal Access Client",
            "secret"                   =>"5MsmlTa44f30TZ7qZzPsK8H5KPiLGT4RmwzAFTLc",
            "provider"                 =>null,
            "redirect"                 =>"http://gym-backend.test",
            "personal_access_client"   =>"1",
            "password_client"          =>"0",
            "revoked"                  =>"0"

        ]);  

        DB::table('oauth_clients')->insert([ 
            "user_id"                  =>null,
            "name"                     =>"Laravel Password Grant Client",
            "secret"                   =>"AXW46UwzTOberih91v9QnFPD0wVVF4DZKW8qYFSG",
            "provider"                 =>'users',
            "redirect"                 =>"http://gym-backend.test",
            "personal_access_client"   =>"0",
            "password_client"          =>"1",
            "revoked"                  =>"0"

        ]); 

        DB::table('oauth_personal_access_clients')->insert([ 
            "client_id"                  =>1,

        ]);
    }
}
