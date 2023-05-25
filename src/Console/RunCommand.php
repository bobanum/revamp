<?php

namespace Bobanum\Revamp\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class RunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revamp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Revamp controllers and resources';

    /**
     * The available stacks.
     *
     * @var array<int, string>
     */
    protected $stacks = ['blade', 'react', 'vue', 'api'];

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        return 1;
    }

    /**
     * Interact with the user to prompt them when the stack argument is missing.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if ($this->argument('stack') === null && $this->option('inertia')) {
            $input->setArgument('stack', 'vue');
        }

        if ($this->argument('stack')) {
            return;
        }

        $input->setArgument('stack', $this->components->choice('Which stack would you like to install?', $this->stacks));

        $input->setOption('dark', $this->components->confirm('Would you like to install dark mode support?'));

        if (in_array($input->getArgument('stack'), ['vue', 'react'])) {
            $input->setOption('typescript', $this->components->confirm('Would you like TypeScript support? (Experimental)'));

            $input->setOption('ssr', $this->components->confirm('Would you like to install Inertia SSR support?'));
        }

        $input->setOption('pest', $this->components->confirm('Would you prefer Pest tests instead of PHPUnit?'));
    }


}
