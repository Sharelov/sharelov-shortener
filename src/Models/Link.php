<?php

namespace Sharelov\Shortener\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    
    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'created_at',
        'updated_at',
        'expires_at'
    ];
    
    protected $fillable = [
        'url',
        'hash',
        'expires_at',
        'expires'
    ];
}
