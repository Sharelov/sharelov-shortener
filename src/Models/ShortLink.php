<?php

namespace Sharelov\Shortener\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortLink extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'expires_at',
    ];

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'relation_type',
        'relation_id',
        'url',
        'hash',
        'expires_at',
        'expires',
    ];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $attributes = [])
    {
        if (collect(class_uses_recursive($this))->contains(SoftDeletes::class)) {
            array_push($this->dates, 'deleted_at');
        }

        parent::__construct($attributes);

        $this->setTable(config('shortener.links_table'));
    }
}
