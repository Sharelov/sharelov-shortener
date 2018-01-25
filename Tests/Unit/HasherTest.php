<?php
namespace Sharelov\Shortener\Test\Unit;

use Sharelov\Shortener\Tests\TestCase;
use Sharelov\Shortener\Utilities\UrlHasher;

class HasherTest extends TestCase
{
    /** @test */
    public function hashCanBeProducedAtSpecifiedLengths()
    {
        $length = rand(3,50);
        // echo "\nGoing for a hash with length=".$length."\n";
        $hash = (new UrlHasher)->make($length);
        // echo $hash."\n";
        $this->assertEquals($length, strlen($hash));

        $length = rand(51,100);
        // echo "\nGoing for a hash with length=".$length."\n";
        $hash = (new UrlHasher)->make($length);
        // echo $hash."\n";
        $this->assertEquals($length, strlen($hash));

        $length = rand(100,150);
        // echo "\nGoing for a hash with length=".$length."\n";
        $hash = (new UrlHasher)->make($length);
        // echo $hash."\n";
        $this->assertEquals($length, strlen($hash));
    }

    /** @test 
    * @expectedException \Exception
    */
    public function hashCantBeProducedWithoutSpecifyingLength()
    {
        $hash = (new UrlHasher)->make();
    }
}
