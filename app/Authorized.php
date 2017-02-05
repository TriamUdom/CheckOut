<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Authorized extends Model
{
    protected $collection = 'authorized';
    public $timestamps = false;
    protected $guarded = [];
}
