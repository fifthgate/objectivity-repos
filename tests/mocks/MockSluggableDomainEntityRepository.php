<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Repositories\Tests\Mocks;

use Fifthgate\Objectivity\Repositories\Infrastructure\Repository\AbstractCacheingSluggableDomainEntityRepository;

class MockSluggableDomainEntityRepository extends AbstractCacheingSluggableDomainEntityRepository
{
    public function __construct(MockSluggableDomainEntityMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}
