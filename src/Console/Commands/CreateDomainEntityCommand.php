<?php

namespace Fifthgate\Objectivity\Repositories\Console\Commands;

use Illuminate\Console\Command;

class CreateDomainEntityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:objectivity-domain-entity';

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
        return 0;
    }
}
