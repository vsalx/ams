<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'customer_id', 'dentist_id', 'appointment_date', 'appointment_time'
    ];

    public function customer() {
        return $this->belongsTo('App\User', 'customer_id');
    }

    public function dentist() {
        return $this->belongsTo('App\User', 'dentist_id');
    }

    public function cancelledBy() {
        return $this->belongsTo('App\User', 'cancelled_by');
    }
}
