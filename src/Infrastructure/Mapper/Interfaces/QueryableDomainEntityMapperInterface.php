<?php

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\Interfaces;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;
use Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\Interfaces\DomainEntityMapperInterface;

interface QueryableDomainEntityMapperInterface extends DomainEntityMapperInterface
{
    public function softDeletes() : bool;

    public function publishes() : bool;

    public function usesSlugs() : bool;

    public function queryOne(array $queryArray) : ? DomainEntityInterface;

    public function queryMany(array $queryArray) : ? DomainEntityCollectionInterface;

    public function queryExcluding(array $includeParameters, array $excludeParameters) : ? DomainEntityCollectionInterface;

    public function save(DomainEntityInterface $domainEntity) : DomainEntityInterface;

    public function delete(DomainEntityInterface $domainEntity);

    public function findDeleted($id) : ? DomainEntityInterface;
}
