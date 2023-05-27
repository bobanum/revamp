<?php

namespace Bobanum\Revamp\Sources;

use Illuminate\Support\Str;

class RequestSource extends Source {
    use \Bobanum\Revamp\FilesTrait;

    static public function source_file_path($pattern) {
        return app_path('Http/Requests/*' . $pattern . 'Request.php');
    }
    public function revamp_name($prefix = '') {
        if (self::$keepOriginalNames) {
            return $prefix . $this->concept->name . 'Request.php';
        }
        return "Request{$prefix}.php";
    }
    public function revamp() {
        $paths = glob(self::source_path());
        if (count($paths) > 0) {
            $this->info('Revamping Requests:');
            foreach ($paths as $path) {
                $prefix = basename($path);
                $prefix = str_replace($this->concept->name, '', $prefix);
                $prefix = str_replace('Request', '', $prefix);
                $link = $this->concept->path($this->revamp_name($prefix));
                $this->linkFileIfNeeded($path, $link);
            }
        } else {
            $this->warn('No request found', '-vv');
        }
    }
}
