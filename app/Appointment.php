<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'customer_id', 'dentist_id', 'appointment_date', 'appointment_time'
    ];
}
