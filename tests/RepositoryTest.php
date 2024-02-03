<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Repositories\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryTest extends ObjectivityReposTestCase {
	use RefreshDatabase;

	public function testDomainEntitySave() {
		
		$entity = $this->generateTestEntity();

		$this->assertEquals("test_slug", $entity->getSlug());
		$this->assertNull($entity->getID());
		
		$entity = $this->repository->save($entity);
		$this->assertNotNull($entity->getID());
		$this->assertEquals("test_slug", $entity->getSlug());
		$this->assertEquals("Test Name", $entity->getName());
	}

	public function testDomainEntityDelete() {
		$entity = $this->generateTestEntity([
			"name" => "Test Name 2",
			"slug" => "test_slug_2"
		]);
		$entity = $this->repository->save($entity);
		$this->assertNotNull($entity->getID());
		$this->assertNotNull($this->repository->find($entity->getID()));
		$id = $entity->getID();
		$this->repository->delete($entity);
		$this->assertNull($this->repository->find($id));

		$this->assertEquals($id, $this->repository->findDeleted($id)->getID());
	}

	public function testFindAll() {
		$entities = [
			[
				"name" => "Test Name A",
				"slug" => "test_slug_a"
			],
			[
				"name" => "Test Name B",
				"slug" => "test_slug_b"
			],
			[
				"name" => "Test Name C",
				"slug" => "test_slug_c"
			],
		];
		foreach ($entities as $entityArray) {
			$this->repository->save($this->generateTestEntity($entityArray));
		}
		$this->assertEquals(3, $this->repository->findAll()->count());
	}

	public function testFindMany() {
		$entities = [
			[
				"name" => "Test Name A",
				"slug" => "test_slug_a"
			],
			[
				"name" => "Test Name B",
				"slug" => "test_slug_b"
			],
			[
				"name" => "Test Name C",
				"slug" => "test_slug_c"
			],
		];
		foreach ($entities as $entityArray) {
			$this->repository->save($this->generateTestEntity($entityArray));
		}
		$results = $this->repository->findAll();
		$this->assertEquals(3, $results->count());	
		$foundResults = $this->repository->findMany([2,3]);
		$this->assertEquals(2, $foundResults->count());
	}

	public function testFindBySlug() {
        $entities = [
			[
				"name" => "Test Name X",
				"slug" => "test_slug_a"
			],
			[
				"name" => "Test Name B",
				"slug" => "test_slug_b"
			],
			[
				"name" => "Test Name X",
				"slug" => "test_slug_c"
			],
		];
		foreach ($entities as $entityArray) {
			$this->repository->save($this->generateTestEntity($entityArray));
		}
		$this->assertEquals(1, $this->repository->findBySlug("test_slug_a")->getID());
    }
}
