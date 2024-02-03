<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Repository;

use Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\Interfaces\DomainEntityDatabaseMapperInterface;
use Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces\DomainEntityRepositoryInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

abstract class AbstractDomainEntityRepository implements DomainEntityRepositoryInterface
{
    protected DomainEntityDatabaseMapperInterface $mapper;

    public function save(DomainEntityInterface $domainEntity): DomainEntityInterface
    {
        return $this->mapper->save($domainEntity);
    }

    public function find(int $id): ?DomainEntityInterface
    {
        return $this->mapper->find($id);
    }

    public function findAll(bool $includeUnpublished = false): ?DomainEntityCollectionInterface
    {
        return $this->mapper->findAll($includeUnpublished);
    }

    public function findMany(array $ids): ?DomainEntityCollectionInterface
    {
        return $this->mapper->findMany($ids);
    }

    public function delete(DomainEntityInterface $domainEntity)
    {
        return $this->mapper->delete($domainEntity);
    }

    public function findDeleted(int $id): ?DomainEntityInterface
    {
        return $this->mapper->findDeleted($id);
    }
}
