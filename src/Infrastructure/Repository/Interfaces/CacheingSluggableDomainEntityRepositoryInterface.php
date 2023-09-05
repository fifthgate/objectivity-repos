<?php

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces;

use Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces\DomainEntityRepositoryInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;

interface CacheingSluggableDomainEntityRepositoryInterface extends SluggableDomainEntityRepositoryInterface
{
    public function findBySlug(string $slug, bool $includeUnpublished = false, bool $fresh = false) : ? DomainEntityInterface; 
}