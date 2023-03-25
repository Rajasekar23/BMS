<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ClassBooking.
 *
 * @package namespace App\Entities;
 */
class ClassBooking extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['class_day_id', 'student_id', 'status', 'booked_at', 'booked_by'];

    protected static function booted()
    {
        self::created(function (self $booking) {
            if (!$booking->booking_id) {
                $soNumber = 'SL'.sprintf('%05s', $booking->id);

                $booking->booking_id = $soNumber;
            }
            $booking->save();
        });
    }

}
