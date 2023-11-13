<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    public function run()
    {
    	$faker = Faker::create('id_ID');
    	for ($i=0; $i < 80; $i++) { 
	    	DB::table('users')->insert([
	            'name' => $faker->name,
	            'email' => $faker->name.'@gmail.com',
	            'password' => Hash::make('password'),
	        ]);
    	}
         // DB::table('users')->insert([
         //        'name' => 'Anshari Farhan',
         //        'email' => 'fanshari11@gmail.com',
         //        'password' => Hash::make('password'),
         //    ]);
    }
}
