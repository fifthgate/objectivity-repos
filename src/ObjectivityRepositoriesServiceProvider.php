<?php

namespace Fifthgate\Objectivity\Repositories;

use Illuminate\Support\ServiceProvider;

use Fifthgate\Objectivity\Repositories\Console\Commands\CreateDomainEntityCommand;

/**
 * @codeCoverageIgnore
 */
class ObjectivityRepositoriesServiceProvider extends ServiceProvider {
 	/**
    * Publishes configuration file.
    *
    * @return  void
    */
    public function boot()
    {
    }

    /**
    * Make config publishment optional by merging the config from the package.
    *
    * @return  void
    */
    public function register()
    {
    }
}