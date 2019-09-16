<?php

use PHPUnit\Framework\TestCase;

class KeyValueTest extends TestCase
{
    protected $maker;

    public function setUp(): void
    {
        $this->maker = new PeterColes\Languages\Maker;
    }

    public function testDefaultSettings()
    {
        $keyValue = $this->maker->keyValue();

        $this->assertEquals(184, $keyValue->count());
        $this->assertEquals((object) ['key' => 'ab', 'value' => 'Abkhazian'], $keyValue->first());
    }

    public function testAlternativeLocale()
    {
        $keyValue = $this->maker->keyValue(null, 'zh');

        $this->assertEquals((object) ['key' => 'ab', 'value' => '阿布哈西亚语'], $keyValue->first());
    }

    public function testAlternativeKeys()
    {
        $keyValue = $this->maker->keyValue(null, null, 'label', 'text');

        $this->assertEquals((object) ['label' => 'zu', 'text' => 'Zulu'], $keyValue->last());
    }
}
