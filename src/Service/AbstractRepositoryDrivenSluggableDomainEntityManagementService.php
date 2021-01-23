<?php

namespace Fifthgate\Objectivity\Service;

use Fifthgate\Objectivity\Repositories\Service\Interfaces\DomainEntityManagementServiceInterface;
use Fifthgate\Objectivity\Repositories\Infrastructure\Repository\Interfaces\DomainEntityRepositoryInterface;
use Fifthgate\Objectivity\Repositories\Service\AbstractRepositoryDrivenDomainEntityManagementService;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

abstract class AbstractRepositoryDrivenSluggableDomainEntityManagementService extends AbstractRepositoryDrivenDomainEntityManagementService implements DomainEntityManagementServiceInterface
{
    public function findBySlug(string $slug) : ? DomainEntityInterface
    {
        return $this->repository->findBySlug($slug);
    }
}
