<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    const MONDAY_NAME = 'Monday';
    const TUESDAY_NAME = 'Tuesday';
    const WEDNESDAY_NAME = 'Wednesday';
    const THURDAY_NAME = 'Thursday';
    const FRIDAY_NAME = 'Friday';
    const SATURDAY_NAME = 'Saturday';
    const SUNDAY_NAME = 'Sunday';

}
