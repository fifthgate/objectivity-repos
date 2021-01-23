<?php

namespace Services\Core\Infrastructure\Repository\Interfaces;

use Services\Core\Domain\Interfaces\DomainEntityInterface;
use Services\Core\Infrastructure\Repository\Interfaces\DomainEntityRepositoryInterface;

interface SluggableDomainEntityRepositoryInterface extends DomainEntityRepositoryInterface
{
    public function findBySlug(string $slug, bool $includeUnpublished = false) : ? DomainEntityInterface;
}
