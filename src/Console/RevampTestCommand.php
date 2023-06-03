<?php

namespace Bobanum\Revamp\Console;

use Illuminate\Support\Str;

class RevampTestCommand extends RevampCommand {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revamp:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'unRevamp the application (removes the "concepts" folder)';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle() {
        $this->info('Trop Cool!');
        return 1;
    }
}
