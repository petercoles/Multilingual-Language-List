<?php

use PHPUnit\Framework\TestCase;

class MixedLocaleTest extends TestCase
{
    protected $maker;
        
    public function setUp(): void
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

    public function testML()
    {
        $languageKeys = $this->maker->lookup('major')->keys()->toArray();
        $mixed = $this->maker->lookup($languageKeys, 'mixed');

        $this->assertArrayHasKey("af", $mixed);
        $this->assertArrayHasKey("zu", $mixed);
    }
}
