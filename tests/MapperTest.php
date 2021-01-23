<?php

namespace Fifthgate\Objectivity\Repositories\Tests;

use Fifthgate\Objectivity\Repositories\Tests\ObjectivityReposTestCase;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntityMapper;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntity;
use \DateTime;

use Illuminate\Foundation\Testing\RefreshDatabase;


class MapperTest extends ObjectivityReposTestCase {

	use RefreshDatabase;

	public function generateTestEntity(array $overrides = []) {
		$entity	= new MockSluggableDomainEntity;
		$entity->setName($overrides["name"] ?? "Test Name");
		$entity->setSlug($overides["slug"] ?? "test_slug");
		$createdAt = new DateTime("2009-09-09 09:09:09");
		$entity->setCreatedAt($overrides["created_at"] ?? $createdAt);
		$entity->setUpdatedAt($overrides["updated_at"] ?? $createdAt);
		return $entity;
	}

	public function testMapperInstantiation() {
		$this->assertFalse($this->mapper->publishes());
		$this->assertTrue($this->mapper->softDeletes());
		$this->assertTrue($this->mapper->usesSlugs());
		$this->assertEquals('id', $this->mapper->getIDColumnName());
		$this->assertEquals('mock_entity_mapper_table', $this->mapper->getTableName());
	}
	
	public function testDomainEntitySave() {
		
		$entity = $this->generateTestEntity();

		$this->assertEquals("test_slug", $entity->getSlug());
		$this->assertNull($entity->getID());
		
		$entity = $this->mapper->save($entity);
		$this->assertNotNull($entity->getID());
		$this->assertEquals("test_slug", $entity->getSlug());
		$this->assertEquals("Test Name", $entity->getName());
	}

	public function testDomainEntityDelete() {
		$entity = $this->generateTestEntity([
			"name" => "Test Name 2",
			"slug" => "test_slug_2"
		]);
		$entity = $this->mapper->save($entity);
		$this->assertNotNull($entity->getID());
		$this->assertNotNull($this->mapper->find($entity->getID()));
		$id = $entity->getID();
		$this->mapper->delete($entity);
		$this->assertNull($this->mapper->find($id));

		$this->assertEquals($id, $this->mapper->findDeleted($id)->getID());
	}
}