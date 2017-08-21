<?php 

namespace Sharelov\Shortener\Facades;

use Illuminate\Support\Facades\Facade;

class Shortener extends Facade {

    protected static function getFacadeAccessor(){
        return 'Shortener';
    }

}