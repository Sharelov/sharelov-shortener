<?php
namespace Sharelov\Shortener\Utilities\Contracts;

interface UrlHasher
{
    public function make(int $length=null);

    public function setCharacterPool(string $str);
}