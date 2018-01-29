<?php

namespace Sharelov\Shortener\Models;

use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
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

    /**
     * Guarded columns array
     * @var  array
     */
    protected $guarded = [];
    
    /**
     * Fillable database columns
     * @var array
     */
    protected $fillable = [
        'relation_type',
        'relation_id',
        'url',
        'hash',
        'expires_at',
        'expires'
    ];

    /**
     * Table name filled from config via getTable()
     * @var string
     */
    protected $table;

    public function getTable()
    {
        $this->table = config('shortener.links_table');
        return $this->table;
    }
}
