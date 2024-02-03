<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\Interfaces;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;

interface SluggableDomainEntityMapperInterface extends DomainEntityMapperInterface
{
    public function findBySlug(string $slug, bool $includeUnpublished = false): ?DomainEntityInterface;

    public function slugExists(string $slug): bool;
}
