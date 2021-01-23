<?php

namespace Fifthgate\Objectivity\Repositories\Tests;

use Orchestra\Testbench\TestCase;
use Fifthgate\Objectivity\Repositories\Tests\Mocks\MockSluggableDomainEntityMapper;
use Illuminate\Database\DatabaseManager as DB;

class ObjectivityReposTestCase extends TestCase {


	protected $mapper;

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
	    $this->loadMigrationsFrom(__DIR__ . '/tests/migrations');
	    $db = $this->app->get(DB::class);
	    $this->mapper = new MockSluggableDomainEntityMapper($db);	
	}
}