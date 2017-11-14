<?php

namespace Sharelov\Shortener;

use Sharelov\Shortener\Exceptions\NonExistentHashException;
use Sharelov\Shortener\Repositories\LinkRepository;
use Sharelov\Shortener\Utilities\UrlHasher;

class ShortenerService
{
    protected $linkRepo;

    private $urlHasher;

    public function __construct(LinkRepository $linkRepo, UrlHasher $urlHasher)
    {
        $this->linkRepo = $linkRepo;
        $this->urlHasher = $urlHasher;
    }

    public function make($url, $expires_at = null)
    {
        $link = $this->linkRepo->byUrl($url);

        return $link || $this->linkRepo->expired($link) ? $link->hash : $this->makeHash($url, $expires_at);
    }

    public function getUrlByHash($hash)
    {
        $link = $this->linkRepo->byHash($hash);

        if (!$link || $this->linkRepo->expired($link)) {
            throw new NonExistentHashException();
        }
        return $link->url;
    }

    private function makeHash($url, $expires_at = null)
    {
        $hash = $this->urlHasher->make($url);

        $expires_at ? $expires = true : $expires = false;

        $data = compact('url', 'hash', 'expires_at', 'expires');

        \Event::fire('Link.creating', [$data]);
        $this->linkRepo->create($data);

        return $hash;
    }
}
