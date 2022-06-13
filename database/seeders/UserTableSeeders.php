<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
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
    }
}
