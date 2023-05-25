<?php

namespace Bobanum\Revamp\Console;

use Illuminate\Console\Command;
// use Illuminate\Filesystem\Filesystem;

class RevampCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revamp:revamp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Revamp controllers and resources';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        return 1;
    }

    

}
