<?php

namespace Bobanum\Revamp\Sources;

class ModelSource extends Source {
    use \Bobanum\Revamp\FilesTrait;

    static public function discover() {
        // Get all the models
        $files = glob(self::source_file_path('*'));
        $concepts = [];
        foreach ($files as $file) {
            $concept = str_replace('.php', '', basename($file));
            if ($concept === 'Model') {
                continue;
            }
            $concepts[] = $concept;
        }
        return $concepts;
    }

    public function revamp_name() {
        if (self::$keepOriginalNames) {
            return $this->concept->name . '.php';
        }
        return "Model.php";
    }
    static public function source_file_path($pattern) {
        $path = app_path('Models/' . $pattern . '.php');
        return $path;
    }
    public function revamp() {
        $path = $this->source_path();

        $link = $this->link_path();
        if (file_exists($path)) {
            $this->info('Revamping Model:');
            $this->linkFileIfNeeded($path, $link);
        } else {
            $this->warn('No controller found', '-vv');
        }
    }
}
