<?php

namespace Fifthgate\Objectivity\Repositories\Service\Interfaces;

use Fifthgate\Objectivity\Repositories\Service\Interfaces\DomainEntityManagementServiceInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

interface SluggableDomainEntityManagementServiceInterface extends DomainEntityManagementServiceInterface
{
    public function findBySlug(string $slug) : ? DomainEntityInterface;
}
