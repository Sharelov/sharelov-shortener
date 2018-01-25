<?php

namespace Sharelov\Shortener\Repositories;

use Sharelov\Shortener\Models\ShortLink;
use Sharelov\Shortener\Models\ShortLinkWithSoftDelete;

class ShortLinkRepository
{
    /**
     * Shortlinks model to be used in the repository
     * @var null
     */
    protected $model = null;

    public function __construct()
    {
        $this->model = new ShortLink;
        if (config('enable_soft_deletes', false)) {
            $this->model = new ShortLinkWithSoftDelete;
        }
        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }
    
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function byUrl($url)
    {
        return $this->model->whereUrl($url)->first();
    }

    public function byHash($hash)
    {
        return $this->model->whereHash($hash)->first();
    }

    public function expired($link)
    {
        return $link && $link->expires && $link->expires_at->diffInDays(null, false) > 0;
    }

    public function destroyByHash($hash)
    {
        return $this->byHash($hash)->destroy();
    }

}
