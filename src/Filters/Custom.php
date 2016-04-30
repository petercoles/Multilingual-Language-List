<?php

namespace PeterColes\Languages\Filters;

class Custom
{
    public function filter($languages, $filter)
    {
        return $languages->filter(function($value, $key) use ($filter) {
            return in_array($key, $filter);
        });
    }
}
