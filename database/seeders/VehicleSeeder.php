<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicles')->insert(
            [
                [
                    'code' => "V001",
                    'name' => "Motorcycle",
                    'standard_quota' => 4,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "V002",
                    'name' => "Three-wheel",
                    'standard_quota' => 5,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "V003",
                    'name' => "Van",
                    'standard_quota' => 20,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "V004",
                    'name' => "Car",
                    'standard_quota' => 20,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "V005",
                    'name' => "Land vehicle",
                    'standard_quota' => 15,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "V006",
                    'name' => "Lorry",
                    'standard_quota' => 50,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "V007",
                    'name' => "Bus",
                    'standard_quota' => 40,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
               
               
              
              
               
            ]
        );
    }
}
