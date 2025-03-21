<?php

namespace ActivityLogBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface LogEntryInterface
 * @package ActivityLogBundle\Entity
 */
interface LogEntryInterface
{
    /**
     * @return string
     */
    public function getObjectId();

    /**
     * @param string $objectId
     */
    public function setObjectId($objectId);

    /**
     * @return string
     */
    public function getParentId();

    /**
     * @param string $parentId
     */
    public function setParentId($parentId);

    /**
     * @return string
     */
    public function getParentClass();

    /**
     * @param string $parentClass
     */
    public function setParentClass($parentClass);

    /**
     * @return array
     */
    public function getOldData();

    /**
     * @param array $oldData
     */
    public function setOldData(array $oldData);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return UserInterface|null
     */
    public function getUser();

    /**
     * @param UserInterface|null $user
     */
    public function setUser($user);

    /**
     * Is action CREATE
     * @return bool
     */
    public function isCreate();

    /**
     * Is action UPDATE
     * @return bool
     */
    public function isUpdate();

    /**
     * Is action DELETE
     * @return bool
     */
    public function isRemove();


    /**
     * Get data
     * @return array
     */
    public function getData();

    /**
     * Set data
     * @param array $data
     */
    public function setData($data);
}
