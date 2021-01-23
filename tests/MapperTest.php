<?php

namespace Fifthgate\Objectivity\Repositories\Tests;

use Fifthgate\Objectivity\Repositories\Tests\ObjectivityReposTestCase;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntityMapper;

class MapperTest extends ObjectivityReposTestCase {

	public function testMapperInstantiation() {
		$this->assertFalse($this->mapper->publishes());
		$this->assertTrue($this->mapper->softDeletes());
		$this->assertTrue($this->mapper->usesSlugs());
		$this->assertEquals('id', $this->mapper->getIDColumnName());
		$this->assertEquals('mock_entity_mapper_table', $this->mapper->getTableName());

	}
	
}