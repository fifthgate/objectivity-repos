<?php

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\Interfaces;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

interface DomainEntityMapperInterface
{
    public function makeCollection() : DomainEntityCollectionInterface;

    public function find(int $id) : ? DomainEntityInterface;

    public function mapEntity(array $result) : DomainEntityInterface;

    public function mapMany(array $results) : ? DomainEntityCollectionInterface;

    public function findAll(bool $includeUnpublished = false) : ? DomainEntityCollectionInterface;

    public function findMany(array $ids) : ? DomainEntityCollectionInterface;
}
