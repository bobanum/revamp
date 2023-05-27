<?php

namespace Bobanum\Revamp\Sources;

use Illuminate\Support\Str;

class MigrationSource extends Source {
    use \Bobanum\Revamp\FilesTrait;

    static public function source_file_path($pattern) {
        $pattern = Str::plural(Str::snake($pattern));
        return glob(database_path('migrations/*_create_' . $pattern . '_table.php'))[0];
    }
    public function revamp_name() {
        if (self::$keepOriginalNames) {
            return "migration.php"; // TODO: make it work with the original name
            // return date('Y_m_d_His') . '_create_' . Str::plural(Str::snake($this->name)) . '_table.php';
        }
        return "migration.php";
    }
    public function revamp() {
        $path = $this->source_path();
        $link = $this->link_path();
        if (file_exists($path)) {
            $this->info('Revamping Migration:');
            $this->linkFileIfNeeded($path, $link);
        }
    }
}
