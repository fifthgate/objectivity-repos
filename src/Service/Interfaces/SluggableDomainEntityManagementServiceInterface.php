<?php

namespace Fifthgate\Objectivity\Repositories\Service\Interfaces;

use Fifthgate\Objectivity\Repositories\Service\Interfaces\DomainEntityManagementServiceInterface;
use Fifthgate\Objectivity\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

interface SluggableDomainEntityManagementServiceInterface extends DomainEntityManagementServiceInterface
{
    public function findBySlug(string $slug) : ? DomainEntityInterface;
}
