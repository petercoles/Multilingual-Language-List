<?php

class LookupTest extends \PHPUnit_Framework_TestCase
{
    protected $maker;
        
    public function setUp()
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

        $this->assertEquals('荷兰文', $lookup['nl']);
    }

    public function testReverseSetting()
    {
        $lookup = $this->maker->lookup(null, 'fr_CA', 'true');

        $this->assertEquals('nb', $lookup['norvégien bokmål']);
    }
}
