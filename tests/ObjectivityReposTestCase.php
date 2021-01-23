<?php

namespace Fifthgate\Objectivity\Repositories\Tests;

use Orchestra\Testbench\TestCase;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntityMapper;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntityRepository;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntity;
use Illuminate\Database\DatabaseManager as DB;
use \DateTime;

class ObjectivityReposTestCase extends TestCase {

	protected $mapper;

	protected $repository;

	public function generateTestEntity(array $overrides = []) {
		$entity	= new MockSluggableDomainEntity;
		if (isset($overrides["id"]) && $overrides["id"]) {
			$entity->setID($overrides["id"]);
		}
		$entity->setName($overrides["name"] ?? "Test Name");
		$entity->setSlug($overrides["slug"] ?? "test_slug");
		$createdAt = new DateTime("2009-09-09 09:09:09");
		$entity->setCreatedAt($overrides["created_at"] ?? $createdAt);
		$entity->setUpdatedAt($overrides["updated_at"] ?? $createdAt);
		return $entity;
	}

  	protected function getPackageProviders($app) {
	}

	protected function getEnvironmentSetUp($app)
	{
		$app['config']->set('key', 'base64:j84cxCjod/fon4Ks52qdMKiJXOrO5OSDBpXjVUMz61s=');
	    // Setup default database to use sqlite :memory:
	    $app['config']->set('database.default', 'testbench');
	    $app['config']->set('database.connections.testbench', [
	        'driver'   => 'sqlite',
	        'database' => ':memory:',
	        'prefix'   => '',
	    ]);
	    //$app['config']->set('smartmenu', $this->testMenuArray);
	}

	/**
	 * Setup the test environment.
	 */
	protected function setUp(): void {
	    parent::setUp();
	    $this->loadMigrationsFrom(__DIR__ . '/migrations');
	    $db = $this->app->get(DB::class);
	    $this->mapper = new MockSluggableDomainEntityMapper($db);	
	    $this->repository = new MockSluggableDomainEntityRepository($this->mapper);

	}
}