<?php

namespace PeterColes\Languages;

class Maker
{
    protected $languages = null;

    public function lookup($filter = 'major', $locale = 'en', $flip = false)
    {
        $this->prep($filter, $locale);

        if ($flip) {
            return $this->languages->flip();
        }

        return $this->languages;
    }

    public function keyValue($filter = 'major', $locale = 'en', $key = 'key', $value = 'value')
    {
        $this->prep($filter, $locale);

        $key = $key ?: 'key';
        $value = $value ?: 'value';

        return $this->languages->transform(function($item, $index) use ($key, $value) {
            return (object) [ $key => $index, $value =>$item ];
        })->values(); 
    }

    protected function prep($filter, $locale)
    {
        $this->getData($locale);

        $this->filter($filter);
    }

    protected function getData($locale)
    {
        if (!$this->languages) {
            $locale = $locale ?: 'en';
            $this->languages = collect(require realpath(__DIR__."/../data/$locale.php"));             
        }
    }

    protected function filter($filter)
    {
        if (!$filter || $filter == 'major') {
            $this->languages = $this->languages->filter(function($value, $key) {
                return strlen($key) == 2;
            });
        }

        if ($filter == 'minor') {
            $this->languages = $this->languages->filter(function($value, $key) {
                return strlen($key) <= 3;
            });
        }
    }
}
