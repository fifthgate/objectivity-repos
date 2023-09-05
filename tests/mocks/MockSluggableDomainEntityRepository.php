<?php

namespace Fifthgate\Objectivity\Repositories\Tests\Mocks;

use Fifthgate\Objectivity\Repositories\Infrastructure\Repository\AbstractCacheingSluggableDomainEntityRepository;

use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntityMapper;

class MockSluggableDomainEntityRepository extends AbstractCacheingSluggableDomainEntityRepository {

	public function __construct(MockSluggableDomainEntityMapper $mapper) {
		$this->mapper = $mapper;
	}
}