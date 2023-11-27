<?php

namespace Sharelov\Shortener\Utilities;

use Sharelov\Shortener\Utilities\Contracts\UrlHasher as HasherContract;
class UrlHasher implements HasherContract
{
    /**
     * @var string
     */
    protected $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';

    /**
     * Generate a new hash.
     *
     * @param int $length [description]
     *
     * @throws \Exception
     *
     * @return string [type] [description]
     */
    public function make($length = null)
    {
        if (!$length || !is_numeric($length)) {
            throw new \Exception('Hash length was not set.');
        }

        $pool = $this->pool;
        $hash = '';
        $max = strlen($pool);

        for ($i = 0; $i < $length; $i++) {
            $hash .= $pool[random_int(0, $max - 1)];
        }

        return $hash;
    }

    /**
     * Set the character pool to something custom
     * @param string $str The string containing the characters to generate a hash from
     * @return self Returns this instance after updating the character pool value.
     */
    public function setCharacterPool(string $str): self
    {
        $this->pool = $str;

        return $this;
    }
}
