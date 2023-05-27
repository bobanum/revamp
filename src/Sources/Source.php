<?php
namespace Bobanum\Revamp\Sources;

abstract class Source {
    use \Illuminate\Console\Concerns\InteractsWithIO;
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

    public function link_path() {
        return $this->concept->path($this->revamp_name());
    }
    abstract static public function source_file_path($file);
    public function source_path() {
        return static::source_file_path($this->concept->name);
    }
    abstract public function revamp();
}