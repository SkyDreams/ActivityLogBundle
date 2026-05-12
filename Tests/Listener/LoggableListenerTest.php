<?php

declare(strict_types=1);

namespace ActivityLogBundle\Tests\Listener;

use ActivityLogBundle\Entity\Interfaces\StringableInterface;
use ActivityLogBundle\Entity\LogEntryInterface;
use ActivityLogBundle\Listener\LoggableListener;
use Gedmo\Tool\ActorProviderInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class LoggableListenerTest extends TestCase
{
    public function testResolvesUserFreshFromActorProviderOnEachCall(): void
    {
        $user1 = $this->createMock(UserInterface::class);
        $user2 = $this->createMock(UserInterface::class);

        $actorProvider = $this->createMock(ActorProviderInterface::class);
        $actorProvider->expects($this->exactly(2))
            ->method('getActor')
            ->willReturnOnConsecutiveCalls($user1, $user2);

        $logEntry1 = $this->createMock(LogEntryInterface::class);
        $logEntry1->expects($this->once())->method('setUser')->with($user1);
        $logEntry1->method('setName');

        $logEntry2 = $this->createMock(LogEntryInterface::class);
        $logEntry2->expects($this->once())->method('setUser')->with($user2);
        $logEntry2->method('setName');

        $object = $this->createMock(StringableInterface::class);
        $object->method('toString')->willReturn('test-entity');

        $listener = new TestableLoggableListener();
        $listener->setActorProvider($actorProvider);

        $listener->callPrePersistLogEntry($logEntry1, $object);
        $listener->callPrePersistLogEntry($logEntry2, $object);
    }

    public function testDoesNotSetUserWhenActorProviderReturnsNull(): void
    {
        $actorProvider = $this->createMock(ActorProviderInterface::class);
        $actorProvider->method('getActor')->willReturn(null);

        $logEntry = $this->createMock(LogEntryInterface::class);
        $logEntry->expects($this->never())->method('setUser');
        $logEntry->method('setName');

        $object = $this->createMock(StringableInterface::class);
        $object->method('toString')->willReturn('test-entity');

        $listener = new TestableLoggableListener();
        $listener->setActorProvider($actorProvider);

        $listener->callPrePersistLogEntry($logEntry, $object);
    }

    public function testDoesNotSetUserWhenNoActorProviderInjected(): void
    {
        $logEntry = $this->createMock(LogEntryInterface::class);
        $logEntry->expects($this->never())->method('setUser');
        $logEntry->method('setName');

        $object = $this->createMock(StringableInterface::class);
        $object->method('toString')->willReturn('test-entity');

        $listener = new TestableLoggableListener();

        $listener->callPrePersistLogEntry($logEntry, $object);
    }
}

class TestableLoggableListener extends LoggableListener
{
    public function callPrePersistLogEntry(LogEntryInterface $logEntry, object $object): void
    {
        $this->prePersistLogEntry($logEntry, $object);
    }
}
