<?php

namespace Fifthgate\Objectivity\Repositories\Tests\Mocks;

use Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\AbstractSluggableDomainEntityMapper;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntity;
use \DateTime;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntityCollection;

class MockSluggableDomainEntityMapper extends AbstractSluggableDomainEntityMapper {
	
	protected string $tableName = 'mock_entity_mapper_table';

    protected bool $publishes = false;

    protected bool $softDeletes = true;

    protected bool $usesSlugs = true;

	public function makeCollection() : DomainEntityCollectionInterface {
        return new MockSluggableDomainEntityCollection;
	}
    
    public function mapEntity(array $result) : DomainEntityInterface {
        $entity = new MockSluggableDomainEntity;
        $entity->setID($result["id"]);
        $entity->setName($result["entity_name"]);
        $entity->setSlug($result["slug"]);
        $entity->setUpdatedAt(new DateTime($result["updated_at"]));
        $entity->setCreatedAt(new DateTime($result["created_at"]));
        return $entity;
    }

    protected function update(DomainEntityInterface $domainEntity) : DomainEntityInterface {

    }
    protected function create(DomainEntityInterface $domainEntity) : DomainEntityInterface {
    	 $id = $this->db->table($this->getTableName())
            ->insertGetId([
                'slug' => $domainEntity->getSlug(),
                'entity_name' => $domainEntity->getName(),
                'created_at' => $domainEntity->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $domainEntity->getUpdatedAt()->format('Y-m-d H:i:s')
        ]);
        $domainEntity->setID($id);
        return $domainEntity;
    }

    
}