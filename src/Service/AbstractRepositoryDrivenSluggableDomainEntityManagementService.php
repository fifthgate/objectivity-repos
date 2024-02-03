<?php

namespace Fifthgate\Objectivity\Repositories\Service;

use Fifthgate\Objectivity\Repositories\Service\Interfaces\SluggableDomainEntityManagementServiceInterface;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;

abstract class AbstractRepositoryDrivenSluggableDomainEntityManagementService extends AbstractRepositoryDrivenDomainEntityManagementService implements SluggableDomainEntityManagementServiceInterface
{
    public function findBySlug(string $slug): ?DomainEntityInterface
    {
        return $this->repository->findBySlug($slug);
    }

    public function slugExists(string $slug): bool
    {
        return $this->repository->slugExists($slug);
    }
}
