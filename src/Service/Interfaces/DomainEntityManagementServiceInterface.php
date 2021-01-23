<?php

namespace Fifthgate\Objectivity\Repositories\Service\Interfaces;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

interface DomainEntityManagementServiceInterface
{
    public function find(int $id) : ? DomainEntityInterface;

    public function findDeleted(int $id) : ? DomainEntityInterface;

    public function findMany(array $fids) : ? DomainEntityCollectionInterface;

    public function findAll() : ? DomainEntityCollectionInterface;

    public function delete(DomainEntityInterface $domainEntity);

    public function save(DomainEntityInterface $domainEntity) : DomainEntityInterface;
}
