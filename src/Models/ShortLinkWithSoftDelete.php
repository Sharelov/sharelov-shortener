<?php

namespace Sharelov\Shortener\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Sharelov\Shortener\Models\ShortLink;

class ShortLinkWithSoftDelete extends ShortLink
{
    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'created_at',
        'updated_at',
        'expires_at',
        'deleted_at'
    ];
    
    protected $fillable = [
        'relation_type',
        'relation_id',
        'url',
        'hash',
        'expires_at',
        'expires'
    ];
}
