<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

interface DomainEntityRepositoryInterface
{
    public function save(DomainEntityInterface $domainEntity): DomainEntityInterface;

    public function find(int $id): ?DomainEntityInterface;

    public function findAll(bool $includeUnpublished = false): ?DomainEntityCollectionInterface;

    public function findMany(array $ids): ?DomainEntityCollectionInterface;

    public function delete(DomainEntityInterface $domainEntity);

    public function findDeleted(int $id): ?DomainEntityInterface;
}
