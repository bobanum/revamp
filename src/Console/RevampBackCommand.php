<?php

namespace Bobanum\Revamp\Console;

use Illuminate\Support\Str;

class RevampBackCommand extends RevampCommand {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revamp:back';

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
        if (!file_exists($this->revamp_path())) {
            $this->info('Nothing to remove : "'. $this->revampFolder. '" folder does not exist');
            return 1;
        }
        $this->info('Removing Revamp folder : '. $this->revampFolder);
        $this->removeDir($this->revamp_path());
        return 1;
    }
}
