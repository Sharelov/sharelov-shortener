<?php

namespace Sharelov\Shortener\Validation;

class LinkValidator extends Validator
{
    protected static $rules = [
        'url' => 'required|url',
        'hash' => 'required|unique:Links,hash',
    ];
}
