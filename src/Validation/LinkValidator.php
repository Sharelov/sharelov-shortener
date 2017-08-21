<?php

namespace Sharelov\Shortener\Validation;

class LinkValidator extends Validator {

    protected static $rules = [
        'url' => 'required|url|unique:Links,ururlencode',
        'hash'=> 'required|unique:Links,hash'

    ];

}