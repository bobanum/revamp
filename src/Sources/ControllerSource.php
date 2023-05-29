<?php

namespace Bobanum\Revamp\Sources;

class ControllerSource extends Source {
    use \Bobanum\Revamp\FilesTrait;

    static public function discover() {
        // Get all the controllers
        $files = glob(self::source_file_path('*'));
        foreach ($files as $file) {
            $concept = str_replace('Controller.php', '', basename($file));
            if (!$concept) {
                continue;
            }
            if (!isset($concepts[$concept])) {
                $concepts[] = $concept;
            }
        }
        return $concepts;
    }

    static public function source_file_path($pattern) {
        $path = app_path('Http/Controllers/' . $pattern . 'Controller.php');
        return $path;
    }
    public function revamp_name($folder = null) {
        if (self::$keepOriginalNames) {
            return ($folder ? $folder . '_' : '') . $this->concept->name . 'Controller.php';
        }
        return "Controller".($folder ? $folder : '').".php";
    }
    public function revamp() {
        $path = $this->source_path();

        $link = $this->link_path();
        if (file_exists($path)) {
            $this->info('Revamping Controller:');
            $this->linkFileIfNeeded($path, $link);
        } else {
            $this->warn('No controller found', '-vv');
        }
        $this->revampSubfolders($path, $link);
    }
}
