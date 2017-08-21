<?php

namespace Sharelov\Shortener\Validation;


use Illuminate\Validation\Factory;

abstract class Validator{

    protected $validator;

    function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    public function fire($data)
    {
        $validation = $this->validator->make($data,static::$rules);

        if($validation->fails()) throw new ValidationExeption($validation->messages());

        return true;
    }

}