<?php
namespace Sharelov\Shortener\Tests\Feature;

use Carbon\Carbon;
use Sharelov\Shortener\Models\ShortLink;
use Sharelov\Shortener\Repositories\ShortLinkRepository;
use Sharelov\Shortener\ShortenerService;
use Sharelov\Shortener\Tests\TestCase;
use Sharelov\Shortener\Utilities\UrlHasher;

class ShortenerServiceTest extends TestCase
{
    /** @test */
    public function modelReturnedByRepositoryDoesNotHaveSoftDeletesAbility()
    {
        $repository = new ShortLinkRepository($this->app['config']['shortener']);
        $model = $repository->getModel();
        $this->assertContainsOnlyInstancesOf(ShortLink::class, [$model]);
    }

    /** @test */
    public function canGenerateHashForUrlAndStoreOnDatabase()
    {
        $shortener_service = (new ShortenerService((new ShortLinkRepository()), (new UrlHasher())));
        
        $hash = $shortener_service->make('https://www.testing.com')->hash;
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
        $shortener_service = (new ShortenerService($repo, (new UrlHasher())));
        
        // generate a url that expired yesterday
        $hash = $shortener_service->make('https://www.testing.com', Carbon::yesterday())->hash;
        $this->assertNotEmpty($hash);

        // fetch that expired url
        $stored_link = $repo->byHash($hash);
        $this->assertNotEmpty($stored_link);

        // make sure it is expired
        $expired = $repo->expired($stored_link);
        $this->assertTrue($expired);
    }

    /** @test */
    public function canGenerateHashAndAutoGrow()
    {

        $shortener_service = (new ShortenerService((new ShortLinkRepository()), (new UrlHasher())));

        $hash="";
        $i =0;
        while (true) {
            // set length to 1 to make this faster
            $hash = $shortener_service->setHashLength(1)->make('https://www.testing.com/'.$hash)->hash;
            // if by 125 loops hash != 2 assertion should fail
            if ($i > 125) {
                $this->assertEquals(strlen($hash), 2);
                break;
            }
            $i++;
        }
    }
}
