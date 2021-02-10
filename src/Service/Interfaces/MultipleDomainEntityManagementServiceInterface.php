<?php

namespace Fifthgate\Objectivity\Repositories\Service\Interfaces;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

interface MultipleDomainEntityManagementServiceInterface {

	public function find(string $type, int $id) : ? DomainEntityInterface;

    public function findDeleted(string $type, int $id) : ? DomainEntityInterface;

    public function findMany(string $type, array $fids) : ? DomainEntityCollectionInterface;

    public function findAllOfType(string $type) : ? DomainEntityCollectionInterface;
}