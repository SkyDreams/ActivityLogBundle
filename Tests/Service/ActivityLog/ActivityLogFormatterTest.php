<?php

namespace Service\ActivityLog;


use ActivityLogBundle\Entity\LogEntry;
use ActivityLogBundle\Service\ActivityLog\ActivityLogFormatter;
use ActivityLogBundle\Service\ActivityLog\EntityFormatter\UniversalFormatter;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ActivityLogFormatterTest extends TestCase
{
    public function testFormat()
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects($this->once())
            ->method('warning');

        $factory = new ActivityLogFormatter($logger);
        $logEntry = new LogEntry();
        $logEntry->setOldData(['test' => 'test']);
        $logEntry->setUsername('username');
        $logEntry->setParentClass('AppBundle\Entity\ParentClass');
        $logEntry->setAction('create');
        $logEntry->setName('Name');
        $logEntry->setParentId('parent-id');
        $logEntry->setData(['test' => 'test1']);
        $logEntry->setObjectClass('AppBundle\Entity\ObjectClass');
        $logEntry->setObjectId('object-id');
        $logEntry->setVersion(2);
        $result = $factory->format([$logEntry]);

        $this->assertTrue(is_array($result[0]));
        $this->assertArrayHasKey('message', $result[0]);
        $this->assertEquals('The entity <b>Name (ObjectClass)</b> was created.', $result[0]['message']);
    }

    public function testCustomFormat()
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects($this->once())
            ->method('warning');

        $factory = new ActivityLogFormatter($logger);
        $logEntry = new LogEntry();
        $logEntry->setOldData(['test' => 'test']);
        $logEntry->setUsername('username');
        $logEntry->setParentClass('AppBundle\Entity\ParentClass');
        $logEntry->setAction('create');
        $logEntry->setName('Name');
        $logEntry->setParentId('parent-id');
        $logEntry->setData(['test' => 'test1']);
        $logEntry->setObjectClass('AppBundle\Entity\UniversalFormatter');
        $logEntry->setObjectId('object-id');
        $logEntry->setVersion(2);
        $result = $factory->format([$logEntry]);

        $this->assertTrue(is_array($result[0]));
        $this->assertArrayHasKey('message', $result[0]);
        $this->assertEquals('The entity <b>Name (UniversalFormatter)</b> was created.', $result[0]['message']);
    }

}
