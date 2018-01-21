<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentDetails extends Model
{
    protected $table = 'appointment_details';

    public $timestamps = false;

    protected $fillable = [
        'description', 'price', 'appointment_id'
    ];
}
