<?php

namespace Bobanum\Revamp\Sources;

use Illuminate\Support\Str;

class ViewSource extends Source {
    use \Bobanum\Revamp\FilesTrait;

    static public function source_file_path($pattern) {
        $path = resource_path('views/' . Str::plural(Str::snake($pattern)));
        if (!file_exists($path)) {
            $path = resource_path('views/' . Str::snake($pattern));
        }
        return $path;
    }
    public function revamp_name($prefix = '') {
        if (self::$keepOriginalNames) {
            return 'views_' . $this->concept->name;
        }
        return "views";
    }
    public function revamp() {
        $path = $this->source_path();
        $link = $this->link_path();
        if (file_exists($path)) {
            $this->info('Revamping Views: ' . $path);
            $this->linkDirIfNeeded($path, $link);
        } else {
            $this->warn('No views folder found', '-vv');
        }
    }
}
