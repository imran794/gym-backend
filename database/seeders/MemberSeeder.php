<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;
use Faker\Factory;


class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facker = Factory::create();


        foreach(range(1, 25) as $item){

        Member::create([
              'member_id'     => date('Y') . str_pad($item, 6, 0, STR_PAD_LEFT),
              'name'          => $facker->name,
              'gender'        => rand(0,1),
              'mobile'        => "01" . rand(3,9) . rand(00000000,99999999),
              'blood_group'   => $facker->bloodGroup(),
              'address'       => $facker->address,
              'photo'         => $facker->imageUrl,
              'created_by'    => rand(1,25)
           ]);

        }


    }
}
