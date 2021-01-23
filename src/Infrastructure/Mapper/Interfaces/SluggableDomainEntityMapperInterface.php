<?php

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\Interfaces;

use Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\Interfaces\DomainEntityMapperInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

interface SluggableDomainEntityMapperInterface extends DomainEntityMapperInterface
{
    public function findBySlug(string $slug, bool $includeUnpublished) : ? DomainEntityInterface;
}
