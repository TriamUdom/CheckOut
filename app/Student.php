<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $collection = 'student';
    public $timestamps = false;
    protected $guarded = [];
}
