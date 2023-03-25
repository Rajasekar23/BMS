<?php

namespace Database\Seeders;

use App\Models\ClassDay;
use App\Models\ClassRoom;
use App\Models\Day;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassDaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->classA();
        $this->classB();
        $this->classC();


    }

    public function classA(){
        $class = ClassRoom::where('name', ClassRoom::CLASS_A)->first();

        $days = Day::whereIn('name', [Day::MONDAY_NAME, Day::TUESDAY_NAME])->get();

        $this->fillClassDays($class, $days);

    }

    public function classB(){
        $class = ClassRoom::where('name', ClassRoom::CLASS_B)->first();

        $days = Day::whereIn('name', [Day::MONDAY_NAME, Day::THURDAY_NAME, Day::SATURDAY_NAME])->get();
        $this->fillClassDays($class, $days);

    }

    public function classC(){
        $class = ClassRoom::where('name', ClassRoom::CLASS_C)->first();

        $days = Day::whereIn('name', [Day::TUESDAY_NAME, Day::FRIDAY_NAME, Day::SATURDAY_NAME])->get();

        $this->fillClassDays($class, $days);

    }

    public function fillClassDays($class, $days){

        foreach($days as $day){

            $classDay = ClassDay::where('class_id', $class->id)->where('day_id',$day->id)->first();
            if(!$classDay){
                $classDay = new ClassDay();
            }
            $classDay->class_id = $class->id;
            $classDay->day_id = $day->id;
            $classDay->save();
        }
    }
}
