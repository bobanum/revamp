<?php

namespace Bobanum\Revamp;

use Illuminate\Console\Command;

trait FilesTrait {
    public function revamp_path($path = "") {
        
        $result = base_path(config('revamp.folder_name', 'concepts'));
        if ($path) {
            $result .= '/' . $path;
        }
        return $result;
    }
    public function makDirIfNotExist($directory) {
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
            $this->info('Created Directory: ' . substr($directory, strlen(base_path()) + 1), 'v', 'vv');
        }
    }
    public function linkFileIfNeeded($source, $destination) {
        if (!file_exists($source)) {
            $this->error('File not found: ' . $source);
            return;
        }
        if (!file_exists($destination)) {
            link($source, $destination);
            $this->info('Linked: ' . substr($destination, strlen(base_path()) + 1), 'vv');
        } else {
            $this->info('Skipped: ' . substr($destination, strlen(base_path()) + 1), 'vv');
        }
    }
    public function linkDirIfNeeded($source, $destination) {
        if (!file_exists($source)) {
            shell_exec("ln -s '$source' -T '$destination'");
            $this->info('Linked: ' . substr($destination, strlen(base_path()) + 1), 'vv');
        } else {
            $this->info('Skipped: ' . substr($destination, strlen(base_path()) + 1), 'vv');
        }
    }
    public function removeDir($path) {
        if (is_file($path)) {
            @unlink($path);
        } else {
            $files = glob($path . '/*');
            $files = array_merge($files, glob($path . '/.*'));
            $files = array_diff($files, [$path . '/.', $path . '/..']);
            array_map([self::class, __FUNCTION__], $files);
            @rmdir($path);
        }
    }
}
