<?php

namespace Fifthgate\Objectivity\Repositories\Tests;

use Fifthgate\Objectivity\Repositories\Tests\ObjectivityReposTestCase;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntityMapper;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntity;
use \DateTime;

use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTest extends ObjectivityReposTestCase {
	use RefreshDatabase;
}