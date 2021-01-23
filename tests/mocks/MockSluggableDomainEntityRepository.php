<?php

namespace Fifthgate\Objectivity\Repositories\Tests\Mocks;

use Fifthgate\Objectivity\Repositories\Infrastructure\Repository\AbstractSluggableDomainEntityRepository;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntityMapper;

class MockSluggableDomainEntityRepository extends AbstractSluggableDomainEntityRepository {

	public function __construct(MockSluggableDomainEntityMapper $mapper) {
		$this->mapper = $mapper;
	}
}