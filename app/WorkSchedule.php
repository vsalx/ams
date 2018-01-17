<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    protected $fillable = [
        'dentist_id', 'start_time', 'end_time'
    ];
}
