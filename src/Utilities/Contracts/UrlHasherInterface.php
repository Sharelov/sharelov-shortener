<?php

namespace Sharelov\Shortener\Utilities\Contracts;

interface UrlHasherInterface
{
    public function make(int $length = null);

    public function setCharacterPool(string $str);
}
