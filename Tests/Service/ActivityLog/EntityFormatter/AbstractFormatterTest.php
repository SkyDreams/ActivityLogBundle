<?php

namespace Service\ActivityLog\EntityFormatter;

use ActivityLogBundle\Service\ActivityLog\EntityFormatter\UniversalFormatter;
use PHPUnit\Framework\TestCase;

class AbstractFormatterTest extends TestCase
{

    public function testNormalizeValue()
    {
        $stub = new UniversalFormatter();

        $result = $stub->normalizeValue('test', ['key' => 'value']);
        $this->assertEquals('key: value;', $result);
        $result = $stub->normalizeValue('test', 'test');
        $this->assertEquals('test', $result);
        $result = $stub->normalizeValue('test', true);
        $this->assertTrue($result);
        $result = $stub->normalizeValue('test', 1);
        $this->assertTrue(is_int($result));
    }
}
