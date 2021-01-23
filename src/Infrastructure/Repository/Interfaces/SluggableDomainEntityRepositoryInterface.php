<?php

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces;

use Fifthgate\Objectivity\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces\DomainEntityRepositoryInterface;

interface SluggableDomainEntityRepositoryInterface extends DomainEntityRepositoryInterface
{
    public function findBySlug(string $slug, bool $includeUnpublished = false) : ? DomainEntityInterface;
}
