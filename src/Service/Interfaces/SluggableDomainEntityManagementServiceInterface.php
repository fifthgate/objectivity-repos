<?php

namespace Services\Core\Service\Interfaces;

use Services\Core\Service\Interfaces\DomainEntityManagementServiceInterface;
use Services\Core\Domain\Interfaces\DomainEntityInterface;

interface SluggableDomainEntityManagementServiceInterface extends DomainEntityManagementServiceInterface
{
    public function findBySlug(string $slug) : ? DomainEntityInterface;
}
