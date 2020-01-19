<?php

namespace App\Routing;

class UrlGenerator extends \Illuminate\Routing\UrlGenerator
{

    public function asset($path, $secure = null)
    {
        return parent::asset(auto_version($path), $secure);
    }

}
