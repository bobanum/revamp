<?php

namespace Bobanum\Revamp;

use Illuminate\Support\Str;

class Concept {
    use \Illuminate\Console\Concerns\InteractsWithIO;
    use \Bobanum\Revamp\FilesTrait;
    public $name;
    public $command;
    public $keepOriginalNames = false;
    static public $sources = [
        Sources\ModelSource::class,
        Sources\ControllerSource::class,
        Sources\MigrationSource::class,
        Sources\SeederSource::class,
        Sources\FactorySource::class,
        Sources\PolicySource::class,
        Sources\RequestSource::class,
        Sources\ViewSource::class,
        Sources\RouteSource::class,
    ];

    public function __construct($name, $command) {
        $this->output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $this->name = $name;
        $this->command = $command;
    }

    public function path($path = "") {
        $result = $this->revamp_path($this->name);
        if ($path) {
            $result .= '/' . $path;
        }
        return $result;
    }

    static public function getConcepts() {
        // Get all the models
        $discovered = array_map(function ($source) {
            return $source::discover();
        }, self::$sources);
        $concepts = array_unique(array_merge(...$discovered));
        return $concepts;
    }

    public function revamp() {
        $this->info('===> Revamping: ' . $this->name);
        $this->makDirIfNotExist($this->revamp_path($this->name));
        foreach (self::$sources as $source) {
            (new $source($this))->revamp();
        }
    }

}
