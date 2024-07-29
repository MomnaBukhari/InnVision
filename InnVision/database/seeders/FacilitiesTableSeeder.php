<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FacilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $facilities = [
            ['name' => 'Free Wi-Fi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Swimming Pool', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Gym', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Spa', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Parking', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Restaurant', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Bar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Room Service', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Laundry Service', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Conference Room', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('facilities')->insert($facilities);
    }
}
