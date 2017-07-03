<?php

use App\Sample;

class SampleTest extends PHPUnit_Framework_TestCase
{
    public function test_サンプル()
    {
        $sample = new Sample;
        $this->assertEquals($sample->test(), 'test');
    }
}
