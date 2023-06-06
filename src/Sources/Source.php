<?php
namespace Bobanum\Revamp\Sources;

abstract class Source {
    use \Illuminate\Console\Concerns\InteractsWithIO;
    use \Bobanum\Revamp\FilesTrait {
        revamp_path as public trait_revamp_path;
    }
    static $keepOriginalNames = false;
    public $concept;

    public function __construct($concept) {
        $this->output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $this->concept = $concept;
    }
    abstract public function revamp_name();
    static public function discover() {
        return [];
    }

    public function revamp_path($file = "") {
        $result = $this->trait_revamp_path($this->concept->name);
        if ($file) {
            $result .= '/' . $file;
        }
        return $result;
    }

    public function link_path() {
        return $this->revamp_path($this->revamp_name());
    }
    abstract static public function source_file_path($file);
    public function source_path() {
        return static::source_file_path($this->concept->name);
    }
    abstract public function revamp();
    public function revampSubfolders($path, $link) {
        $pattern = dirname($path).'/*/'.basename($path);
        $files = glob($pattern);
        foreach ($files as $file) {
            $sublink = str_replace('.php', '_'.basename(dirname($file)).'.php', $link);
            $this->linkFileIfNeeded($file, $sublink);
        }
    }
}
