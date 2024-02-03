<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Repositories\Service\Interfaces;

use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;

interface SluggableDomainEntityManagementServiceInterface extends DomainEntityManagementServiceInterface
{
    public function findBySlug(string $slug) : ? DomainEntityInterface;

    public function slugExists(string $slug) : bool;
}
