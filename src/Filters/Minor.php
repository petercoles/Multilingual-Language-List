<?php

namespace PeterColes\Languages\Filters;

class Minor
{
    public function filter($languages)
    {
        return $languages->filter(function($value, $key) {
            return strlen($key) <= 3;
        });
    }
}
