<?php

namespace Bobanum\Revamp\Sources;

use Illuminate\Support\Str;

class SeederSource extends Source {
    use \Bobanum\Revamp\FilesTrait;

    static public function source_file_path($pattern) {
        return database_path('seeders/' . $pattern . 'Seeder.php');
    }
    public function revamp_name() {
        if (self::$keepOriginalNames) {
            return $this->concept->name . 'Seeder.php';
        }
        return "Seeder.php";
    }
    public function revamp() {
        $path = $this->source_path();
        $link = $this->link_path();
        if (file_exists($path)) {
            $this->info('Revamping Seeder:');
            $this->linkFileIfNeeded($path, $link);
        } else {
            $this->warn('No seeder found', '-vv');
        }
    }
}
