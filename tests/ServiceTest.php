<?php

namespace Fifthgate\Objectivity\Repositories\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTest extends ObjectivityReposTestCase
{
    use RefreshDatabase;

    public function testDomainEntitySave()
    {

        $entity = $this->generateTestEntity();
        $this->assertFalse($this->service->slugExists('test_slug'));
        $this->assertEquals("test_slug", $entity->getSlug());
        $this->assertNull($entity->getID());

        $entity = $this->service->save($entity);
        $this->assertNotNull($entity->getID());
        $this->assertEquals("test_slug", $entity->getSlug());
        $this->assertEquals("Test Name", $entity->getName());
        $this->assertTrue($this->service->slugExists('test_slug'));
    }

    public function testDomainEntityDelete()
    {
        $entity = $this->generateTestEntity([
            "name" => "Test Name 2",
            "slug" => "test_slug_2"
        ]);
        $entity = $this->service->save($entity);
        $this->assertNotNull($entity->getID());
        $this->assertNotNull($this->service->find($entity->getID()));
        $id = $entity->getID();
        $this->service->delete($entity);
        $this->assertNull($this->service->find($id));

        $this->assertEquals($id, $this->service->findDeleted($id)->getID());
    }

    public function testFindAll()
    {
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
            $this->service->save($this->generateTestEntity($entityArray));
        }
        $this->assertEquals(3, $this->service->findAll()->count());
    }

    public function testFindMany()
    {
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
            $this->service->save($this->generateTestEntity($entityArray));
        }
        $results = $this->service->findAll();
        $this->assertEquals(3, $results->count());
        $foundResults = $this->service->findMany([2,3]);
        $this->assertEquals(2, $foundResults->count());
    }

    public function testFindManyEmpty()
    {
        $foundResults = $this->service->findMany([]);
        $this->assertNull($foundResults);
    }

    public function testFindBySlug()
    {
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
            $this->service->save($this->generateTestEntity($entityArray));
        }
        $this->assertEquals(1, $this->service->findBySlug("test_slug_a")->getID());
    }
}
