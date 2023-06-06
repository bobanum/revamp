<?php

namespace Bobanum\Revamp\Sources;

class Source {
    use \Illuminate\Console\Concerns\InteractsWithIO;
    use \Bobanum\Revamp\FilesTrait {
        revamp_path as public trait_revamp_path;
    }
    static $keepOriginalNames = false;
    public $concept;

    public function __construct($concept = null) {
        $this->output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $this->concept = $concept;
    }
    public function revamp_name() {
        if (static::$keepOriginalNames) {
            return $this->concept->name;
        }
        return $this->concept->name . '_' . $this->concept->revamp_name;
    }
    static public function discover() {
        return [];
    }

    public function revamp_path($file = "") {
        $result = $this->trait_revamp_path(isset($this->concept) ? $this->concept->name : '');
        if ($file) {
            $result .= '/' . $file;
        }
        return $result;
    }

    public function link_path() {
        return $this->revamp_path($this->revamp_name());
    }
    static public function source_file_path($file) {
        return base_path($file);
    }
    public function source_path() {
        return static::source_file_path($this->concept->name);
    }
    public function revamp() {
        $this->makDirIfNotExist($this->revamp_path());
        $this->revampFiles($this->concept->files);
    }
    public function revampSubfolders($path, $link) {
        $pattern = dirname($path) . '/*/' . basename($path);
        $files = glob($pattern);
        foreach ($files as $file) {
            $sublink = str_replace('.php', '_' . basename(dirname($file)) . '.php', $link);
            $this->linkFileIfNeeded($file, $sublink);
        }
    }
 
    public function revampFiles($files, $prefix = "") {
        foreach ($files as $destination => $source) {
            if ($destination[0] == '/') {
                $this->makDirIfNotExist($this->revamp_path($prefix));
                $destination = $prefix . substr($destination, 1) . '/';
                $this->revampFiles($source, $destination);
                continue;
            }
            $this->makDirIfNotExist($this->revamp_path($prefix));
            if (is_array($source)) {
                $source = call_user_func($source[1], $source[0]);
            } else {
                $source = base_path($source);
            }
            $paths = glob($source);
            foreach ($paths as $path) {
                $path = str_replace('\\', '/', $path);
                if (is_dir($path)) {
                    $this->revampSubfolders($path, $destination);
                    continue;
                }
                $patternSource = '#^'.str_replace('*', '(.+)', $source).'$#i';
                $patternSource = str_replace('\\', '/', $patternSource);
                $destination = $this->revamp_path($prefix . $destination);
                $destination = str_replace('\\', '/', $destination);
                $destination = preg_replace($patternSource, $destination, $path);
                $this->linkFileIfNeeded($path, $destination);
            }
        }
    }
}
