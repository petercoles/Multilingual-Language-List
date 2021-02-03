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
        if ($locale == 'mixed') {
            $this->getMixedData($filter);
        } else {
            $this->getData($locale);
            $this->filter($filter);
        }
    }

    protected function getMixedData($filter)
    {
        $languages = [ ];
        foreach ($filter as $locale) {
            $filePath = realpath(__DIR__."/../data/$locale.php");
            if (file_exists($filePath)) {
                $language = require $filePath;
                $languages[ $locale ] = $language[ $locale ];
            }
        }

        $this->languages = collect($languages);             
    }

    protected function getData($locale)
    {
        $locale = $locale ?: 'en';

        $this->languages = collect(require realpath(__DIR__."/../data/$locale.php"));             
    }

    protected function filter($filter)
    {
        if (is_array($filter)) {
            $class = '\\PeterColes\\Languages\\Filters\\Custom';
            $this->languages = call_user_func([ new $class, 'filter' ], $this->languages, $filter);
        } else {
            $filter = $filter ?: 'major';
            $class = '\\PeterColes\\Languages\\Filters\\'.ucfirst($filter);
            $this->languages = call_user_func([ new $class, 'filter' ], $this->languages);
        }
    }
}
