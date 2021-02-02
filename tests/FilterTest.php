<?php

use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    protected $maker;
        
    public function setUp(): void
    {
        $this->maker = new PeterColes\Languages\Maker;
    }

    public function testNullFilter()
    {
        $lookup = $this->maker->lookup(null);
        
        $this->assertArrayHasKey('es', $lookup);
        $this->assertArrayHasKey('en', $lookup);
        $this->assertArrayNotHasKey('ain', $lookup);
    }

    public function testMajorFilter()
    {
        $lookup = $this->maker->lookup('major');

        $this->assertArrayHasKey('es', $lookup);
        $this->assertArrayHasKey('en', $lookup);
        $this->assertArrayNotHasKey('ain', $lookup);
    }

    public function testMinorFilter()
    {
        $lookup = $this->maker->lookup('minor');

        $this->assertArrayHasKey('es', $lookup);
        $this->assertArrayHasKey('en', $lookup);
        $this->assertArrayHasKey('ain', $lookup);
    }
    
    public function testAllFilter()
    {
        $lookup = $this->maker->lookup('all');
        
        $this->assertArrayHasKey('es', $lookup);
        $this->assertArrayHasKey('en', $lookup);
        $this->assertArrayHasKey('ain', $lookup);
    }

    public function testArrayFilter()
    {
        $lookup = $this->maker->lookup(['en', 'fr']);

        $this->assertArrayHasKey('en', $lookup);
        $this->assertArrayHasKey('fr', $lookup);
        $this->assertArrayNotHasKey('de', $lookup);
    }
}
