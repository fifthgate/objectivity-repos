<?php

namespace Fifthgate\Objectivity\Repositories\Tests;

use Orchestra\Testbench\TestCase;

class ObjectivityReposTestCase extends TestCase {

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
	}
}