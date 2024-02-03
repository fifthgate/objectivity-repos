<?php

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Repository;

use Fifthgate\Objectivity\Repositories\Infrastructure\Repository\AbstractCacheingDomainEntityRepository;
use Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces\CacheingSluggableDomainEntityRepositoryInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;

abstract class AbstractCacheingSluggableDomainEntityRepository extends AbstractCacheingDomainEntityRepository implements CacheingSluggableDomainEntityRepositoryInterface
{
    public function findBySlug(string $slug, bool $includeUnpublished = false, bool $fresh = false): ?DomainEntityInterface
    {
        return $this->mapper->findBySlug($slug, $includeUnpublished);
    }

    public function slugExists(string $slug): bool
    {
        return $this->mapper->slugExists($slug);
    }

}
