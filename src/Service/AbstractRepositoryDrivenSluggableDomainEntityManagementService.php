<?php

namespace Services\Core\Service;

use Services\Core\Service\Interfaces\DomainEntityManagementServiceInterface;
use Services\Core\Infrastructure\Repository\Interfaces\DomainEntityRepositoryInterface;
use Services\Core\Service\AbstractRepositoryDrivenDomainEntityManagementService;
use Services\Core\Domain\Interfaces\DomainEntityInterface;
use Services\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

abstract class AbstractRepositoryDrivenSluggableDomainEntityManagementService extends AbstractRepositoryDrivenDomainEntityManagementService implements DomainEntityManagementServiceInterface
{
    public function findBySlug(string $slug) : ? DomainEntityInterface
    {
        return $this->repository->findBySlug($slug);
    }
}
