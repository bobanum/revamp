<?php

namespace Bobanum\Revamp\Sources;

use Illuminate\Support\Str;

class FactorySource extends Source {

    static public function source_file_path($pattern) {
        return database_path('factories/' . $pattern . 'Factory.php');
    }
    public function revamp_name() {
        if (config('revamp.shorten_names', true)) {
            return "Factory.php";
        }
        return $this->concept->name . 'Factory.php';
    }
    public function revamp() {
        $path = $this->source_path();
        $link = $this->link_path();
        if (file_exists($path)) {
            $this->info('Revamping Factory', 'vv');
            $this->linkFileIfNeeded($path, $link);
        } else {
            $this->info('No factory found', 'vvv');
        }
    }
}
