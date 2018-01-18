<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $timestamps = false;

    public function reviewer() {
        return $this->belongsTo('App\User', 'reviewer_id');
    }
}
