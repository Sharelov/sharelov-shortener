<?php

namespace Sharelov\Shortener\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ShortLinkWithSoftDelete extends ShortLink
{
    use SoftDeletes;
}
