<?php

namespace Bobanum\Revamp;

use Illuminate\Console\Command;

trait FilesTrait {
    public $revampFolder = 'concepts';
    public function revamp_path($path = "") {
        $result = base_path($this->revampFolder);
        if ($path) {
            $result .= '/' . $path;
        }
        return $result;
    }
    public function makDirIfNotExist($directory) {
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
            $this->info('Created Directory: ' . substr($directory, strlen(base_path()) + 1));
        }
    }
    public function linkFileIfNeeded($source, $destination) {
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
            array_map([self::class, __FUNCTION__], glob($path . '/*'));
            @rmdir($path);
        }
    }
}
