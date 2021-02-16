<?php

namespace Fifthgate\Objectivity\Repositories\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class CreateDomainEntityCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:objectivity-domain-entity {entityName} {--withMigration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new objectivity domain entity.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $entityName = $this->argument('entityName');
        $withMigration = $this->option('withMigration');

        if ($withMigration) {
            $this->createMigration();
        }
        $this->createEntity($entityName);
        return 0;
    }

    protected function createMigration() {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('entityName'))));
        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    protected function createEntity(string $entityName) {
        var_dump($this->laravel->basePath($entityName));
        die("Hello World");
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
                        ? $customPath
                        : __DIR__.$stub;
    }

    protected function getStub() {

    }
}
