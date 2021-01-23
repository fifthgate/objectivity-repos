<?php

namespace Fifthgate\Objectivity\Repositories\Service;

use Fifthgate\Objectivity\Repositories\Service\Interfaces\DomainEntityManagementServiceInterface;
use Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces\DomainEntityRepositoryInterface;
use Fifthgate\Objectivity\Repositories\Service\AbstractDomainEntityManagementService;
use Fifthgate\Objectivity\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

abstract class AbstractRepositoryDrivenDomainEntityManagementService extends AbstractDomainEntityManagementService implements DomainEntityManagementServiceInterface
{
    protected $repository;

    abstract public function getEntityInfo() : array;
    
    public function __construct(DomainEntityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(int $id) : ? DomainEntityInterface
    {
        return $this->repository->find($id);
    }

    public function findDeleted(int $id) : ? DomainEntityInterface
    {
        return $this->repository->findDeleted($id);
    }

    public function findMany(array $fids) : ? DomainEntityCollectionInterface
    {
        return $this->repository->findMany($fids);
    }

    public function findAll() : ? DomainEntityCollectionInterface
    {
        return $this->repository->findAll();
    }

    public function delete(DomainEntityInterface $domainEntity)
    {
        return $this->repository->delete($domainEntity);
    }

    public function save(DomainEntityInterface $domainEntity) : DomainEntityInterface
    {
        return $this->repository->save($domainEntity);
    }
}
