<?php

namespace Bobanum\Revamp\Sources;

class PolicySource extends Source {
    use \Bobanum\Revamp\FilesTrait;

    static public function source_file_path($pattern) {
        return app_path('Policies/' . $pattern . 'Policy.php');
    }
    public function revamp_name() {
        if (self::$keepOriginalNames) {
            return $this->concept->name . 'Policy.php';
        }
        return "Policy.php";
    }
    public function revamp() {
        $path = $this->source_path();
        $link = $this->link_path();
        if (file_exists($path)) {
            $this->info('Revamping Policy:');
            $this->linkFileIfNeeded($path, $link);
        } else {
            $this->warn('No policy found', '-vv');
        }
    }
}
