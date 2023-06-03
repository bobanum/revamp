<?php

namespace Bobanum\Revamp\Sources;

use Illuminate\Support\Str;

class RouteSource extends Source {
    use \Bobanum\Revamp\FilesTrait;

    static public function source_file_path($pattern) {
        $pattern = Str::snake($pattern);
        $path = base_path('routes/' . $pattern . '.php');
        if (!file_exists($path)) {
            $path = base_path('routes/' . Str::plural($pattern) . '.php');
        }
        return $path;
    }
    public function revamp_name() {
        if (config('revamp.shorten_names', true)) {
            return "routes.php";
        }
        return "routes_" . $this->concept->name . '.php';
    }
    public function revampRoutes() {
    }
    public function revamp() {
        $path = $this->source_path();
        $link = $this->link_path();
        if (file_exists($path)) {
            $this->info('Revamping Routes', 'vv');
            $this->linkFileIfNeeded($path, $link);
        } else {
            $this->warn('No separate routes file found', 'vvv');
        }
    }
}
