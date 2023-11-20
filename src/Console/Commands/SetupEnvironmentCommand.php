<?php

namespace IBoot\CMS\Console\Commands;

use Illuminate\Console\Command;

class SetupEnvironmentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:environment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup environment by running migrate and various seed commands';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('migrate');

        $this->info('Environment setup completed.');
    }

    protected function seed($class)
    {
        $this->call('db:seed', ['--class' => $class]);
        $this->info("Seeded: $class");
    }
}
