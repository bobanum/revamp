<?php

namespace Bobanum\Revamp\Console;

use Illuminate\Support\Str;

class RevampRefreshCommand extends RevampCommand {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revamp:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reRevamp the application (removes the "concepts" folder and re-revamps)';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle() {
        $this->call('revamp:back');
        $this->call('revamp');
        return 1;
    }
}
