<?php

namespace Entity\MappedSuperclass;

use ActivityLogBundle\Entity\MappedSuperclass\AbstractLogEntry;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AbstractLogEntryTest extends TestCase
{
    public function testSetParentId()
    {
        $entity = $this->getEntityMock();
        $entity->setParentId('parent-id');
        $this->assertEquals('parent-id', $entity->getParentId());
    }

    public function testSetParentClass()
    {
        $entity = $this->getEntityMock();
        $entity->setParentClass('ParentClass');
        $this->assertEquals('ParentClass', $entity->getParentClass());
    }

    public function testSetUser()
    {
        $user = $this->getMockBuilder('Symfony\Component\Security\Core\User\UserInterface')
            ->getMock();
        $entity = $this->getEntityMock();
        $entity->setUser($user);
        $this->assertInstanceOf(
            'Symfony\Component\Security\Core\User\UserInterface',
            $entity->getUser()
        );
    }
    
    public function testSetEmptyUser()
    {
        $entity = $this->getEntityMock();

        $entity->setUser(null);
        $this->assertNull($entity->getUser());
    }

    /**
     * @return MockObject|AbstractLogEntry
     */
    private function getEntityMock() {
        return $this->getMock(
            'ActivityLogBundle\Entity\MappedSuperclass\AbstractLogEntry'
        );
    }
}
