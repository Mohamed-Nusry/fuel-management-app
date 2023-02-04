<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('districts')->insert(
            [
                [
                    'code' => "D01",
                    'name' => "Ampara",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D02",
                    'name' => "Anuradhapura",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D03",
                    'name' => "Badulla",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D04",
                    'name' => "Batticaloa",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D05",
                    'name' => "Colombo",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D06",
                    'name' => "Galle",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D07",
                    'name' => "Gampaha",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D08",
                    'name' => "Hambantota",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D09",
                    'name' => "Jaffna",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D10",
                    'name' => "Kalutara",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D11",
                    'name' => "Kandy",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D12",
                    'name' => "Kegalle",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D13",
                    'name' => "Kilinochchi",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D14",
                    'name' => "Kurunegala",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D15",
                    'name' => "Mannar",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D16",
                    'name' => "Matale",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D17",
                    'name' => "Matara",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D18",
                    'name' => "Monaragala",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D19",
                    'name' => "Mullaitivu",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D20",
                    'name' => "Nuwara Eliya",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D21",
                    'name' => "Polonnaruwa",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D22",
                    'name' => "Puttalam",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D23",
                    'name' => "Ratnapura",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D24",
                    'name' => "Trincomalee",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
                [
                    'code' => "D25",
                    'name' => "Vavuniya",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => "2023-02-04 11:33:48",
                ],
       
               
               
              
              
               
            ]
        );
    }
}
