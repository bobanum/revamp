<?php

namespace Bobanum\Revamp\Sources;

class PolicySource extends Source {

    static public function source_file_path($pattern) {
        return app_path('Policies/' . $pattern . 'Policy.php');
    }
    public function revamp_name() {
        if (config('revamp.shorten_names', true)) {
            return "Policy.php";
        }
        return $this->concept->name . 'Policy.php';
    }
    public function revamp() {
        $path = $this->source_path();
        $link = $this->link_path();
        if (file_exists($path)) {
            $this->info('Revamping Policy', 'vv');
            $this->linkFileIfNeeded($path, $link);
        } else {
            $this->warn('No policy found', 'vvv');
        }
    }
}
