<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authorized extends Model
{
    protected $colection = 'authorized';
    public $timestamps = false;
    protected $guarded = [];
}
