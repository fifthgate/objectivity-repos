<?php

declare(strict_types=1);

namespace Fifthgate\Objectivity\Repositories\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntityCollection;

class MapperTest extends ObjectivityReposTestCase
{

    use RefreshDatabase;

    public function testMapperInstantiation()
    {
        $this->assertFalse($this->mapper->publishes());
        $this->assertTrue($this->mapper->softDeletes());
        $this->assertTrue($this->mapper->usesSlugs());
        $this->assertEquals('id', $this->mapper->getIDColumnName());
        $this->assertEquals('mock_entity_mapper_table', $this->mapper->getTableName());
    }
    
    public function testDomainEntitySave()
    {
        
        $entity = $this->generateTestEntity();

        $this->assertEquals("test_slug", $entity->getSlug());
        $this->assertNull($entity->getID());
        
        $entity = $this->mapper->save($entity);
        $this->assertNotNull($entity->getID());
        $this->assertEquals("test_slug", $entity->getSlug());
        $this->assertEquals("Test Name", $entity->getName());
    }

    public function testDomainEntityDelete()
    {
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
            $this->mapper->save($this->generateTestEntity($entityArray));
        }
        $this->assertEquals(3, $this->mapper->findAll()->count());
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
            $this->mapper->save($this->generateTestEntity($entityArray));
        }
        $results = $this->mapper->findAll();
        $this->assertEquals(3, $results->count());
        $foundResults = $this->mapper->findMany([2,3]);
        $this->assertEquals(2, $foundResults->count());
    }

    public function testQueryOne()
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
            $this->mapper->save($this->generateTestEntity($entityArray));
        }
        $result = $this->mapper->queryOne(["entity_name" => "Test Name A", "slug" => "test_slug_a"]);
        $this->assertEquals(1, $result->getID());
        $this->assertEquals("Test Name A", $result->getName());
        $this->assertEquals("test_slug_a", $result->getSlug());
    }

    public function testQueryMany()
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
            $this->mapper->save($this->generateTestEntity($entityArray));
        }
        $results = $this->mapper->queryMany(["entity_name" => "Test Name X"]);
        $this->assertEquals(2, $results->count());
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
            $this->mapper->save($this->generateTestEntity($entityArray));
        }
        $this->assertEquals(1, $this->mapper->findBySlug("test_slug_a")->getID());
    }

    public function testCreateSaveCollection()
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
        
        $entityCollection = new MockSluggableDomainEntityCollection;
        
        foreach ($entities as $entityArray) {
            $entityCollection->add($this->generateTestEntity($entityArray));
        }
        $savedCollection = $this->mapper->saveCollection($entityCollection);
        $this->assertEquals(3, $savedCollection->count());

        foreach ($savedCollection as $item) {
            $this->assertNotNull($item->getID());
        }
        $savedEntityB = $savedCollection->filterByFieldValue("getSlug", "test_slug_b")->first();
        $this->assertNotNull($savedEntityB);
        $this->assertEquals("test_slug_b", $savedEntityB->getSlug());
        $this->assertEquals("Test Name B", $savedEntityB->getName());
    }

    public function testQueryExcluding()
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
            $this->mapper->save($this->generateTestEntity($entityArray));
        }
        /**
         * Simply Exclude test.
         */
        $results = $this->mapper->queryExcluding([], ["entity_name" => "Test Name X"]);
        $this->assertEquals(1, $results->count());
        $this->assertEquals("Test Name B", $results->first()->getName());
        $this->assertEquals("test_slug_b", $results->first()->getSlug());

        /**
         * Include/Exclude Test.
         */
        $results2 = $this->mapper->queryExcluding(["entity_name" => "Test Name X"], ["slug" => "test_slug_a"]);
        $this->assertNotNull($results2);
        $this->assertEquals(1, $results2->count());
        $this->assertEquals("Test Name X", $results2->first()->getName());
        $this->assertEquals("test_slug_c", $results2->first()->getSlug());

        /**
         * Simple Include Test
         */
        $results3 = $this->mapper->queryExcluding(["entity_name" => "Test Name X"], []);
        $this->assertNotNull($results3);
        $this->assertEquals(2, $results3->count());
    }
}
