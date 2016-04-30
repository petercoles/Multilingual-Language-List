<?php

namespace PeterColes\Languages\Filters;

use Illuminate\Support\Collection;

class Major
{
    public function filter(Collection $languages)
    {
        return $languages->filter(function($value, $key) {
            return strlen($key) == 2;
        });
    }
}
