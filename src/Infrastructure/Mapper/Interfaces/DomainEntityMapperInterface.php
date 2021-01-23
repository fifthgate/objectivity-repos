<?php

namespace Services\Core\Infrastructure\Mapper\Interfaces;

use Services\Core\Domain\Interfaces\DomainEntityInterface;
use Services\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

interface DomainEntityMapperInterface
{
    public function softDeletes() : bool;

    public function publishes() : bool;

    public function getIDColumnName() : string;

    public function getTableName() : string;

    public function queryOne(array $queryArray) : ? DomainEntityInterface;

    public function queryMany(array $queryArray) : ? DomainEntityCollectionInterface;

    public function save(DomainEntityInterface $domainEntity) : DomainEntityInterface;

    public function find(int $id) : ? DomainEntityInterface;

    public function mapEntity(array $result) : DomainEntityInterface;

    public function mapMany(array $results) : ? DomainEntityCollectionInterface;

    public function findAll(bool $includeUnpublished = false) : ? DomainEntityCollectionInterface;

    public function delete(DomainEntityInterface $domainEntity);

    public function findDeleted(int $id) : ? DomainEntityInterface;
}
