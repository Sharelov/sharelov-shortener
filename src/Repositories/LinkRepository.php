<?php

namespace Sharelov\Shortener\Repositories;

use Sharelov\Shortener\Models\Link;

class LinkRepository
{
    public function create(array $data)
    {
        return Link::create($data);
    }

    public function byUrl($url)
    {
        return Link::whereUrl($url)->first();
    }

    public function byHash($hash)
    {
        return Link::whereHash($hash)->first();
    }

    public function expired($link)
    {
        return $link && $link->expires && $link->expires_at->diffInDays(null, false) > 0;
    }
}
