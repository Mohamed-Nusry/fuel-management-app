<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'first_name' => "FuelIn",
                    'last_name' => "Head",
                    'name' => "fuelinhead",
                    'email' => "headoffice@gmail.com",
                    'password' => Hash::make('fuelin@123'),
                    'user_type' => 1,
                    'fuel_station_id' => null,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'first_name' => "Alex",
                    'last_name' => "Wood",
                    'name' => "alex15",
                    'email' => "alex@gmail.com",
                    'password' => Hash::make('alex@123'),
                    'user_type' => 2,
                    'fuel_station_id' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'first_name' => "John",
                    'last_name' => "Log",
                    'name' => "john15",
                    'email' => "john@gmail.com",
                    'password' => Hash::make('john@123'),
                    'user_type' => 3,
                    'fuel_station_id' => null,
                    'created_at' => "2023-02-04 11:33:48",
                ],
               
               
              
              
               
            ]
        );
    }
}
