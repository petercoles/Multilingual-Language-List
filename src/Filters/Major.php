<?php

namespace PeterColes\Languages\Filters;

class Major
{
    public function filter($languages)
    {
        return $languages->filter(function($value, $key) {
            return strlen($key) == 2;
        });
    }
}
