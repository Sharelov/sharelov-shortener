<?php

namespace Sharelov\Shortener\Utilities;

class UrlHasher
{
    public function make($url, $length = 5)
    {
        // define alphabet. separated in group types for clarity
        $pool = '0123456789';
        $pool .= 'abcdefghijklmnopqrstuvwxyz';
        $pool .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pool .= '_-~';
        // initialize the hash var
        $hash = "";
        // count the length of the alphabet pool
        $max = strlen($pool);

        // do the rounds selecting one character until we reach the specified length
        for ($i = 0; $i < $length; ++$i) {
            $hash .= $pool[random_int(0, $max - 1)];
        }

        // we are done, return the hash
        return $hash;
    }
}
