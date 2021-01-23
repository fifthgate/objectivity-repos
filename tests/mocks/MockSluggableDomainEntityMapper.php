<?php

namespace Fifthgate\Objectivity\Repositories\Tests\Mocks;


use Fifthgate\Objectivity\Repositories\Infrastructure\Mapper\AbstractSluggableDomainEntityMapper;
use Fifthgate\Objectivity\Core\Domain\Interfaces\DomainEntityInterface;
use Fifthgate\Objectivity\Core\Domain\Collection\Interfaces\DomainEntityCollectionInterface;

class MockSluggableDomainEntityMapper extends AbstractSluggableDomainEntityMapper {
	
	protected string $tableName = 'mock_entity_mapper_table';

    protected bool $publishes = false;

    protected bool $softDeletes = true;

    protected bool $usesSlugs = true;

	public function makeCollection() : DomainEntityCollectionInterface {

	}
    
    public function mapEntity(array $result) : DomainEntityInterface {

    }

    protected function update(DomainEntityInterface $domainEntity) : DomainEntityInterface {

    }
    protected function create(DomainEntityInterface $domainEntity) : DomainEntityInterface {

    }
}