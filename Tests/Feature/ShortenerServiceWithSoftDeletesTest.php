<?php

namespace Sharelov\Shortener\Tests\Feature;

use Illuminate\Support\Carbon;
use Sharelov\Shortener\Models\ShortLink;
use Sharelov\Shortener\Models\ShortLinkWithSoftDelete;
use Sharelov\Shortener\Repositories\ShortLinkRepository;
use Sharelov\Shortener\ShortenerService;
use Sharelov\Shortener\Tests\TestCaseWithSoftDeletes;
use Sharelov\Shortener\Utilities\UrlHasher;

class ShortenerServiceWithSoftDeletesTest extends TestCaseWithSoftDeletes
{
    /** @test */
    public function modelReturnedByRepositoryHasSoftDeletesAbility()
    {
        $repository = new ShortLinkRepository($this->app->config['shortener']);
        $model = $repository->getModel();
        $this->assertContainsOnlyInstancesOf(ShortLinkWithSoftDelete::class, [$model]);
    }

    /** @test */
    public function modelHasDeletedAtColumnPresent()
    {
        $repository = new ShortLinkRepository($this->app->config['shortener']);

        $shortener_service = (new ShortenerService($repository, new UrlHasher()));

        $link = $shortener_service->make('https://www.testing.com');
        $this->assertContainsOnlyInstancesOf(ShortLinkWithSoftDelete::class, [$link]);
        $link->delete();
        $this->assertEquals(isset($link->deleted_at), true);
        $this->assertNotEmpty($link->hash);
    }

    /** @test */
    public function canGenerateHashForUrlAndStoreOnDatabase()
    {
        $shortener_service = (new ShortenerService(
            new ShortLinkRepository($this->app->config['shortener']),
            new UrlHasher()
        ));

        $link = $shortener_service->make('https://www.testing.com');
        $this->assertNotEmpty($link->hash);

        $stored_link = ShortLink::find($link->id);
        $this->assertNotEmpty($stored_link);
        $this->assertNotEmpty($stored_link->url);
    }

    /**
     * @test
     *
     * @depends canGenerateHashForUrlAndStoreOnDatabase
     */
    public function canGenerateHashForUrlAndStoreOnDatabaseThatsExpired()
    {
        $repo = new ShortLinkRepository($this->app->config['shortener']);
        $shortener_service = (new ShortenerService($repo, new UrlHasher()));

        // generate a url that expired yesterday
        $link = $shortener_service->make('https://www.testing.com', Carbon::yesterday());
        $this->assertNotEmpty($link->hash);

        // fetch that expired url
        $stored_link = $repo->byHash($link->hash);
        $this->assertNotEmpty($stored_link);

        // make sure it is expired
        $expired = $repo->expired($stored_link);
        $this->assertTrue($expired);
    }

    /** @test */
    public function canGenerateHashAndAutoGrow()
    {
        $shortener_service = (new ShortenerService(
            new ShortLinkRepository($this->app->config['shortener']),
            new UrlHasher()
        ));

        $hash = '';
        $i = 0;
        while (true) {
            // set length to 1 to make this faster
            $hash = $shortener_service->setHashLength(1)->make('https://www.testing.com/'.$hash)->hash;
            // if by 150 loops hash != 2 assertion should fail
            if ($i > 175) {
                $this->assertEquals(strlen($hash), 2);
                break;
            }
            $i++;
        }
    }
}
