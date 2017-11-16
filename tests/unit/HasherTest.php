<?php
namespace Sharelov\Shortener\Test;

use PHPUnit\Framework\TestCase;
use Sharelov\Shortener\Utilities\UrlHasher;

class HasherTest extends TestCase
{
    /** @test */
    public function hashCanBeProducedAtSpecifiedLengths()
    {
        $length = 5;
        $hash = (new UrlHasher)->make($length);
        $this->assertEquals($length, strlen($hash));

        $length = 8;
        $hash = (new UrlHasher)->make($length);
        $this->assertEquals($length, strlen($hash));
    }
}
