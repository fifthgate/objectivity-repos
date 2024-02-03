<?php

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Repository;

use Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces\SluggableDomainEntityRepositoryInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;

abstract class AbstractSluggableDomainEntityRepository extends AbstractDomainEntityRepository implements SluggableDomainEntityRepositoryInterface
{
    public function findBySlug(string $slug, bool $includeUnpublished = false) : ? DomainEntityInterface
    {
        return $this->mapper->findBySlug($slug, $includeUnpublished);
    }

    public function slugExists(string $slug): bool
    {
        return $this->mapper->slugExists($slug);
    }
}
