<?php

namespace Bobanum\Revamp\Sources;

use Illuminate\Support\Str;

class MigrationSource extends Source
{
    use \Bobanum\Revamp\FilesTrait;

    static public function source_file_path($pattern)
    {
        $pattern = Str::plural(Str::snake($pattern));
        $files = glob(database_path('migrations/*_create_' . $pattern . '_table.php'));
        if (count($files) === 0)
            return false;
        return $files[0];
    }
    public function revamp_name()
    {
        if (config('revamp.shorten_names', true)) {
            return "migration.php";
        }
        return "migration.php"; // TODO: make it work with the original name
        // return date('Y_m_d_His') . '_create_' . Str::plural(Str::snake($this->name)) . '_table.php';
    }
    public function revamp()
    {
        $path = $this->source_path();
        $link = $this->link_path();
        if (file_exists($path)) {
            $this->info('Revamping Migration', 'vv');
            $this->linkFileIfNeeded($path, $link);
        } else {
            $this->warn('No migration found', 'vvv');
        }
    }
}
