<?php

namespace Sharelov\Shortener\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    //

    protected $fillable = ['url','hash'];
}
