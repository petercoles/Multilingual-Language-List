<?php

namespace PeterColes\Languages\Filters;

use Illuminate\Support\Collection;

class Minor
{
    public function filter(Collection $languages)
    {
        return $languages->filter(function($value, $key) {
            return strlen($key) <= 3;
        });
    }
}
