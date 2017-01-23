<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class User extends Model
{
    protected $collection = 'user';
    public $timestamps = false;
    protected $guarded = [];

}
