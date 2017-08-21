<?php 

namespace Sharelov\Shortener;

use Sharelov\Shortener\Exceptions\NonExistentHashException;
use Sharelov\Shortener\Repositories\LinkRepository;
use Sharelov\Shortener\Utilities\UrlHasher;

class ShortenerService {

    protected $linkRepo;

    private $urlHasher;

    function __construct(LinkRepository $linkRepo, UrlHasher $urlHasher){
        $this->linkRepo = $linkRepo;
        $this->urlHasher = $urlHasher;
    }

    public function make ($url)
    {
        $link = $this->linkRepo->byUrl($url);

        return $link? $link->hash : $this->makeHash($url);
    }

    public function getUrlByHash ($hash)
    {
        $link = $this->linkRepo->byHash($hash);

        if (! $link ) throw new NonExistentHashException;

        return $link->url;
    }

    private function makeHash ($url)
    {
        $hash = $this->urlHasher->make($url);

        $data = compact('url','hash');

        \Event::fire('Link.creating',[$data]);
        $this->linkRepo->create($data);

        return $hash;
    }

}