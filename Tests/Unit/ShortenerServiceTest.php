<?php
namespace Sharelov\Shortener\Tests\Unit;

use Carbon\Carbon;
use Sharelov\Shortener\Models\ShortLink;
use Sharelov\Shortener\Repositories\ShortLinkRepository;
use Sharelov\Shortener\ShortenerService;
use Sharelov\Shortener\Tests\TestCase;
use Sharelov\Shortener\Utilities\UrlHasher;

class ShortenerServiceTest extends TestCase
{
    /** @test */
    public function canGenerateHashForUrlAndStoreOnDatabase()
    {
        $shortener_service = app(ShortenerService::class)->setUrlHasher((new UrlHasher()))
        ->setShortLinkRepository(new ShortLinkRepository());
        
        $hash = $shortener_service->make('https://www.testing.com');
        $this->assertNotEmpty($hash);

        $stored_link = ShortLink::first();
        $this->assertNotEmpty($stored_link);
        $this->assertNotEmpty($stored_link->url);
    }

    /** 
     * @test
     * @depends canGenerateHashForUrlAndStoreOnDatabase
     */
    public function canGenerateHashForUrlAndStoreOnDatabaseThatsExpired()
    {
        $repo = new ShortLinkRepository();
        $shortener_service = app(ShortenerService::class)->setUrlHasher((new UrlHasher()))
        ->setShortLinkRepository($repo);
        
        // generate a url that expired yesterday
        $hash = $shortener_service->make('https://www.testing.com', Carbon::yesterday());
        $this->assertNotEmpty($hash);

        // fetch that expired url
        $stored_link = $repo->byHash($hash);
        $this->assertNotEmpty($stored_link);

        // make sure it is expired
        $expired = $repo->expired($stored_link);
        $this->assertTrue($expired);
    }
}
