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

    /**
     * This test only for coverage - it's not test any real behaviors
     */
    public function testNormalizeValueByMethod()
    {
        $stub = $this->createMock(
            'ActivityLogBundle\Service\ActivityLog\EntityFormatter\AbstractFormatter',
        );
        $stub->method('test')
            ->willReturn('test');

        $result = $stub->normalizeValue('test', 'test');
        $this->assertEquals('test', $result);
    }
}
