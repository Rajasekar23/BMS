<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\ClassDay;
use App\Models\ClassBooking;
use App\Models\ClassRoom;
use App\Models\Day;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Validators\ClassBookingValidator;
use App\Repositories\ClassBookingRepository;
use Illuminate\Validation\ValidationException;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ClassBookingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ClassBookingRepositoryEloquent extends BaseRepository implements ClassBookingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClassBooking::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ClassBookingValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function create(array $attributes): ClassBooking
    {

        $class  = $this->getClassByName($attributes['class_name']);
        $day  = $this->getDayByName($attributes['day']);

        $classDay = $this->getClassDay($class, $day);

        if(!$classDay){
            $response = ['message' => 'Class Timetable Not Found for id : '.$attributes['class_name']];
            throw ValidationException::withMessages($response);
        }

        $attributes['class_day_id'] = $classDay->id;
        $timeInterval = $this->getStartAndEodOfWeek();
        $currentWeekBookings = $this->getTotalBookedSlots($classDay, $timeInterval->start_of_week, $timeInterval->end_of_week);

        if($currentWeekBookings >= $class->seat_capacity){
            $response = ['message' => 'Slot not available for '.$class->name];
            throw ValidationException::withMessages($response);
        }

        $user = Auth::user();
        if(!isset($attributes['booked_at'])){
            $attributes['booked_at'] = Carbon::now();
            if($user){
                $attributes['booked_by'] = $user->id;
            }
        }

        return parent::create($attributes);

    }

    public function getClassByName($className): ClassRoom
    {

        return ClassRoom::where('name', $className)->first();
    }

    public function getDayByName($dayName): Day
    {
        return Day::where('name', $dayName)->first();
    }

    public function getClassDay($class, $day): ClassDay
    {
        return ClassDay::where('class_id', $class->id)->where('day_id', $day->id)->first();
    }

    public function getStartAndEodOfWeek()
    {
        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

        return (object) ['start_of_week' => $weekStartDate, 'end_of_week' => $weekEndDate];
    }

    public function getAvailableSlots(){

        $timeInterval = $this->getStartAndEodOfWeek();

        $classes = ClassRoom::where('is_active', 1)->get();
        $result =[];
        foreach($classes as $class){
            $data['name'] = $class->name;

            $classDays = $class->classDays;
            if($classDays){
                $slots = [];
                foreach($classDays as $classDay){
                    $day = $classDay->day;
                    $bookedSeatCounts = $this->getTotalBookedSlots($classDay, $timeInterval->start_of_week, $timeInterval->end_of_week);
                    $slots[] = [
                        'name' => $day->name,
                        'booked_seats' => $bookedSeatCounts,
                        'available_seats' => $class->seat_capacity - $bookedSeatCounts,
                        'total_seat_capacity' => $class->seat_capacity
                    ];
                }
                $data['slots'] = $slots;
            }

            $result[] = $data;

        }
        return $result;
    }

    public function getTotalBookedSlots($classDay, $startDate, $endDate) {

        return ClassBooking::whereBetween('booked_at', [$startDate, $endDate])
                            ->where('class_day_id', $classDay->id)
                            ->where('status', 'BOOKED')->count();
    }

    public function cancelSlot($bookingId)
    {
        $classBooking = ClassBooking::where('booking_id', $bookingId)->first();
        if(!$classBooking){
            $response = ['message' => 'Booking Not Found for id : '.$bookingId];
            throw ValidationException::withMessages($response);
        }
        $classBooking->status = 'CANCELED';
        $classBooking->save();

        return [
            'message' => 'ClassBooking Canceled.',
            'data'    => $classBooking->toArray(),
        ];
    }

}
