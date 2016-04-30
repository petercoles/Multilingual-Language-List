<?php

namespace PeterColes\Languages\Filters;

use Illuminate\Support\Collection;

class Custom
{
    public function filter(Collection $languages, $filter)
    {
        return $languages->filter(function($value, $key) use ($filter) {
            return in_array($key, $filter);
        });
    }
}
