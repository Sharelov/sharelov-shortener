<?php

namespace Sharelov\Shortener\Repositories;

use Sharelov\Shortener\Models\ShortLink;

class ShortLinkRepository
{
    public function create(array $data)
    {
        return ShortLink::create($data);
    }

    public function byUrl($url)
    {
        return ShortLink::whereUrl($url)->first();
    }

    public function byHash($hash)
    {
        return ShortLink::whereHash($hash)->first();
    }

    public function expired($link)
    {
        return $link && $link->expires && $link->expires_at->diffInDays(null, false) > 0;
    }
}
