<?php

namespace Services\Core\Infrastructure\Mapper\Interfaces;

use Services\Core\Infrastructure\Mapper\Interfaces\DomainEntityMapperInterface;
use Services\Core\Domain\Interfaces\DomainEntityInterface;
use Services\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

interface SluggableDomainEntityMapperInterface extends DomainEntityMapperInterface
{
    public function findBySlug(string $slug, bool $includeUnpublished) : ? DomainEntityInterface;
}
