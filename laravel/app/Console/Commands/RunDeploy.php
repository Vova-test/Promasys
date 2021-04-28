<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunDeploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run-deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'key:generate + make:migration';

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
     * @return mixed
     */
    public function handle()
    {
        $this->call('key:generate');
        $this->call('encryption_key:generate');
        $this->call('migrate');
    }
}
