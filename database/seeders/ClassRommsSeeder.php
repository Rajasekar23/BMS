<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassRommsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $slots = [
            [
                'name' => 'Class A',
                'seat_capacity' => 10,
                'from_time' => DB::raw("TIME( STR_TO_DATE( '09:00 AM', '%h:%i %p' ) )"),
                'to_time' => DB::raw("TIME( STR_TO_DATE( '06:00 PM', '%h:%i %p' ) )"),
            ],
            [
                'name' => 'Class B',
                'seat_capacity' => 15,
                'from_time' => DB::raw("TIME( STR_TO_DATE( '08:00 AM', '%h:%i %p' ) )"),
                'to_time' => DB::raw("TIME( STR_TO_DATE( '06:00 PM', '%h:%i %p' ) )"),
            ],
            [
                'name' => 'Class C',
                'seat_capacity' => 7,
                'from_time' => DB::raw("TIME( STR_TO_DATE( '03:00 PM', '%h:%i %p' ) )"),
                'to_time' => DB::raw("TIME( STR_TO_DATE( '10:00 PM', '%h:%i %p' ) )"),
            ]
        ];

        foreach($slots as $slot){

            $classRoom = ClassRoom::updateOrCreate(
                ['name' => $slot['name']],
                $slot
            );
        }
    }
}
