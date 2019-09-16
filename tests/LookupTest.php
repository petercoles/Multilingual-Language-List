<?php

use PHPUnit\Framework\TestCase;

class LookupTest extends TestCase
{
    protected $maker;

    public function setUp(): void
    {
        $this->maker = new PeterColes\Languages\Maker;
    }

    public function testDefaultSettings()
    {
        $lookup = $this->maker->lookup();

        $this->assertEquals('Hiri Motu', $lookup['ho']);
    }

    public function testLocaleSetting()
    {
        $lookup = $this->maker->lookup(null, 'zh');

        $this->assertEquals('荷兰语', $lookup['nl']);
    }

    public function testReverseSetting()
    {
        $lookup = $this->maker->lookup(null, 'fr_CA', 'true');

        $this->assertEquals('nb', $lookup['norvégien bokmål']);
    }
}
