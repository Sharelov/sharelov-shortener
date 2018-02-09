<?php

namespace Sharelov\Shortener\Repositories;

use Sharelov\Shortener\Models\ShortLink;
use Sharelov\Shortener\Models\ShortLinkWithSoftDelete;

class ShortLinkRepository
{
    /**
     * Shortlinks model to be used in the repository.
     *
     * @var null
     */
    protected $model = null;
    protected $model_class_name = null;

    public function __construct($config = null)
    {
        $this->model = new ShortLink();
        $this->model_class_name = 'ShortLink';

        if (config('shortener.enable_soft_deletes') && array_get($config, 'enable_soft_deletes')) {
            $this->model = new ShortLinkWithSoftDelete();
            $this->model_class_name = 'ShortLinkWithSoftDelete';
        }

        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getModelClassName()
    {
        return $this->model_class_name;
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
