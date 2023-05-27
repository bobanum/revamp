<?php

namespace Bobanum\Revamp\Sources;

use Illuminate\Support\Str;

class FactorySource extends Source {
    use \Bobanum\Revamp\FilesTrait;

    static public function source_file_path($pattern) {
        return database_path('factories/' . $pattern . 'Factory.php');
    }
    public function revamp_name() {
        if (self::$keepOriginalNames) {
            return $this->concept->name . 'Factory.php';
        }
        return "Factory.php";
    }
    public function revamp() {
        $path = $this->source_path();
        $link = $this->link_path();
        if (file_exists($path)) {
            $this->info('Revamping Factory:');
            $this->linkFileIfNeeded($path, $link);
        }
    }
}
