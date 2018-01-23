<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'dentist_id', 'work_date', 'start_time', 'end_time'
    ];
}
