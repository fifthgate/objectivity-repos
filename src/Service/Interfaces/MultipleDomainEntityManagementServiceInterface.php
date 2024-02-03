<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Repositories\Service\Interfaces;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

interface MultipleDomainEntityManagementServiceInterface {

	public function find(string $typeMachineName, $id) : ? DomainEntityInterface;

    public function findDeleted(string $typeMachineName, $id) : ? DomainEntityInterface;

    public function findMany(string $typeMachineName, array $ids) : ? DomainEntityCollectionInterface;

    public function findAllOfType(string $typeMachineName) : ? DomainEntityCollectionInterface;
}