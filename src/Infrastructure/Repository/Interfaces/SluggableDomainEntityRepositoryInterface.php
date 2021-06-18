<?php

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces;

use Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces\DomainEntityRepositoryInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;

interface SluggableDomainEntityRepositoryInterface extends DomainEntityRepositoryInterface
{
    public function findBySlug(string $slug, bool $includeUnpublished = false) : ? DomainEntityInterface;

    public function slugExists(string $slug): bool;
}
