<?php

namespace Bobanum\Revamp\Sources;

use Illuminate\Support\Str;

class GlobalSource extends Source {
    use \Bobanum\Revamp\FilesTrait {
        revamp_path as revamp_path_trait;
    }

    public function __construct() {
        $this->output = new \Symfony\Component\Console\Output\ConsoleOutput();
    }
    public function revamp_path($path = "") {
        $result = $this->revamp_path_trait("_global");
        if ($path) {
            $result .= '/' . $path;
        }
        return $result;
    }
    static public function source_file_path($pattern = "") {
        return base_path($pattern);
    }
    public function revamp_name($prefix = '') {
        if (config('revamp.shorten_names', true)) {
            return "views";
        }
        return 'views_' . $this->concept->name;
    }
    public function revamp() {
        $files = [
            'routes_web.php' => 'routes/web.php',
            'routes_api.php' => 'routes/api.php',
            'DatabaseSeeder.php' => ['seeders/DatabaseSeeder.php', 'database_path'],
            '.env' => '.env',
            'Controller.php' => ['Http/Controllers/Controller.php', 'app_path'],
            'Model.php' => ['Models/Model.php', 'app_path'],
        ];
        $this->makDirIfNotExist($this->revamp_path());
        foreach ($files as $destination => $source) {
            if(is_array($source)) {
                $source = call_user_func($source[1], $source[0]);
            } else {
                $source = base_path($source);
            }
            $destination = $this->revamp_path($destination);
            $this->linkFileIfNeeded($source, $destination);
        }
    }
}
