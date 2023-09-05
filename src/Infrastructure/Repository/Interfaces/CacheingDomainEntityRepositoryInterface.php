<?php

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces;

use Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces\DomainEntityRepositoryInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

interface CacheingDomainEntityRepositoryInterface extends DomainEntityRepositoryInterface
{
    public function find(int $id, bool $fresh = false) : ? DomainEntityInterface;
    
    public function findAll(bool $includeUnpublished = false, bool $fresh = false) : ? DomainEntityCollectionInterface;

    public function findMany(array $ids, bool $fresh = false) : ? DomainEntityCollectionInterface;
}
