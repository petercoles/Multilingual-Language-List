<?php

class MixedLocaleTest extends \PHPUnit_Framework_TestCase
{
    protected $maker;
        
    public function setUp()
    {
        $this->maker = new PeterColes\Languages\Maker;
    }

    public function testLookup()
    {
        $lookup = $this->maker->lookup(['en', 'fr', 'de', 'ja', 'ru', 'zh'], 'mixed');

        $expected = [
            'en' => 'English',
            'fr' => 'français',
            'de' => 'Deutsch',
            'ja' => '日本語',
            'ru' => 'русский',
            'zh' => '中文',
        ];

        $this->assertEquals($expected, $lookup->toArray());
    }

    public function testKeyValue()
    {
        $keyValue = $this->maker->keyValue(['en', 'fr', 'de', 'ja', 'ru', 'zh'], 'mixed');

        $expected = [
            (object) ['key' => 'en', 'value' => 'English'],
            (object) ['key' => 'fr', 'value' => 'français'],
            (object) ['key' => 'de', 'value' => 'Deutsch'],
            (object) ['key' => 'ja', 'value' => '日本語'],
            (object) ['key' => 'ru', 'value' => 'русский'],
            (object) ['key' => 'zh', 'value' => '中文'],
        ];

        $this->assertEquals($expected, $keyValue->toArray());
    }
}
