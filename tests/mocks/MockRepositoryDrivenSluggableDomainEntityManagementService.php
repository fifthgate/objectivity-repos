<?php

namespace Fifthgate\Objectivity\Repositories\Tests\Mocks;

use Fifthgate\Objectivity\Repositories\Service\AbstractRepositoryDrivenSluggableDomainEntityManagementService;

class MockRepositoryDrivenSluggableDomainEntityManagementService extends AbstractRepositoryDrivenSluggableDomainEntityManagementService {
	
	    public function getEntityInfo() : array
    {
        return [
            'MockSluggableDomainEntityInterface' => [
                'name' => 'Mock Sluggable Domain Entity Interface',
                'softDeletes' => true,
                'publishes' => false,
                'timestamps' => true
            ]
        ];
    }
}