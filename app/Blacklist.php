<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    public $timestamps = false;
    public $table = 'blacklists';
    protected $fillable = [
        'user_id', 'reporter_id'
    ];
}
