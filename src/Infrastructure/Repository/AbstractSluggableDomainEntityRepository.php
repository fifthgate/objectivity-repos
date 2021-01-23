<?php

namespace Services\Core\Infrastructure\Repository;

use Services\Core\Infrastructure\Repository\AbstractDomainEntityRepository;
use Services\Core\Infrastructure\Repository\Interfaces\SluggableDomainEntityRepositoryInterface;
use Services\Core\Domain\Interfaces\DomainEntityInterface;

/**
 * @codeCoverageIgnore
 */
abstract class AbstractSluggableDomainEntityRepository extends AbstractDomainEntityRepository implements SluggableDomainEntityRepositoryInterface
{
    public function findBySlug(string $slug, bool $includeUnpublished = false) : ? DomainEntityInterface
    {
        return $this->mapper->findBySlug($slug, $includeUnpublished);
    }
}
