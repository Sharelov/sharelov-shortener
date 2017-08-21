<?php

namespace Sharelov\Shortener\Utilities;

class UrlHasher {


    public function make($url){
        $pool = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

        return substr(str_shuffle(str_repeat($pool,5)),0,5);
    }

}