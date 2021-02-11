<?php

namespace Fifthgate\Objectivity\Repositories\Service\Interfaces;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

interface MultipleDomainEntityManagementServiceInterface {

	public function find(string $type, $id) : ? DomainEntityInterface;

    public function findDeleted(string $type, $id) : ? DomainEntityInterface;

    public function findMany(string $type, array $ids) : ? DomainEntityCollectionInterface;

    public function findAllOfType(string $type) : ? DomainEntityCollectionInterface;
}