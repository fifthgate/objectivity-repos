<?php

namespace Fifthgate\Objectivity\Repositories\Tests;

use Fifthgate\Objectivity\Repositories\Tests\ObjectivityReposTestCase;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntityMapper;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntity;
use \DateTime;

class MapperTest extends ObjectivityReposTestCase {

	public function testMapperInstantiation() {
		$this->assertFalse($this->mapper->publishes());
		$this->assertTrue($this->mapper->softDeletes());
		$this->assertTrue($this->mapper->usesSlugs());
		$this->assertEquals('id', $this->mapper->getIDColumnName());
		$this->assertEquals('mock_entity_mapper_table', $this->mapper->getTableName());
	}
	
	public function testDomainEntitySave() {
		$entity	= new MockSluggableDomainEntity;
		$entity->setName("Test Name");
		$entity->setSlug("test_slug");
		$this->assertEquals("test_slug", $entity->getSlug());
		$createdAt = new DateTime("2009-09-09 09:09:09");
		$entity->setCreatedAt($createdAt);
		$entity->setUpdatedAt($createdAt);
		$this->mapper->save($entity);
	}
}