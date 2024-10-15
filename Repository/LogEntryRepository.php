<?php

namespace ActivityLogBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Gedmo\Loggable\Entity\Repository\LogEntryRepository as BaseRepository;
use Doctrine\ORM\Query;
use Gedmo\Tool\Wrapper\EntityWrapper;

/**
 * Class LogEntryRepository
 * @package ActivityLogBundle\Repository
 */
class LogEntryRepository extends BaseRepository
{
    /**
     * Get the query for loading of log entries
     *
     * @param object $entity
     *
     * @return Query
     */
    public function getLogEntriesQuery($entity)
    {
        $wrapped = new EntityWrapper($entity, $this->getEntityManager());
        $objectClass = $wrapped->getMetadata()->name;
        $meta = $this->getClassMetadata();
        $dql = "SELECT log FROM {$meta->name} log";
        $dql .= " WHERE (log.objectId = :objectId AND log.objectClass = :objectClass)";
        $dql .= " OR (log.parentId = :parentId AND log.parentClass = :parentClass)";
        $dql .= " ORDER BY log.version DESC, log.loggedAt ASC";

        $objectId = $wrapped->getIdentifier();
        $q = $this->getEntityManager()->createQuery($dql);
        $q->setParameters([
            'objectId' => $objectId,
            'objectClass' => $objectClass,
            'parentId' => $objectId,
            'parentClass' => $objectClass,
        ]);

        return $q;
    }

    /**
     * Get the query builder for loading of log entries
     *
     * @param object $entity
     *
     * @return QueryBuilder
     */
    public function getLogEntriesQueryBuilder($entity)
    {
        $wrapped = new EntityWrapper($entity, $this->getEntityManager());
        $meta = $this->getClassMetadata();

        $qb = $this->getEntityManager()->createQueryBuilder();
        $or = $qb->expr()->orX(
            'log.objectId = :objectId AND log.objectClass = :objectClass',
            'log.parentId = :parentId AND log.parentClass = :parentClass'
        );
        $qb->select('log')
            ->from($meta->name, 'log')
            ->andWhere($or)
            ->addOrderBy('log.loggedAt', 'DESC');

        $objectClass = $wrapped->getMetadata()->name;
        $objectId = $wrapped->getIdentifier();
        $qb->setParameter('objectId', $objectId)
            ->setParameter('objectClass', $objectClass)
            ->setParameter('parentId', $objectId)
            ->setParameter('parentClass', $objectClass);

        return $qb;
    }
}
