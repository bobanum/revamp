<?php

namespace Bobanum\Revamp\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RevampCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revamp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revamp the application';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle() {
        $this->info('Installing Revamp...');
        $this->makDirIfNotExist(base_path('concepts'));
        $concepts = $this->getConcepts();
        $this->revamp($concepts);
        return 1;
    }
    public function makDirIfNotExist($directory) {
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
            $this->info('Created Directory: ' . substr($directory, strlen(base_path()) + 1));
        }
    }
    public function getConcepts() {
        // Get all the models
        $files = glob(app_path('Models/*.php'));
        $concepts = [];
        foreach ($files as $file) {
            $concept = str_replace('.php', '', basename($file));
            if ($concept === 'Model') {
                continue;
            }
            $concepts[] = $concept;
        }
        // Get all the controllers
        $files = glob(app_path('Http/Controllers/*.php'));
        foreach ($files as $file) {
            $concept = str_replace('Controller.php', '', basename($file));
            if (!$concept) {
                continue;
            }
            if (!isset($concepts[$concept])) {
                $concepts[] = $concept;
            }
        }
        return $concepts;
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
        if (is_dir($source)) {
            shell_exec("ln -s \"$source\" \"$destination\"");
            $this->info('Linked: ' . substr($destination, strlen(base_path()) + 1), 'vv');
        } else {
            $this->info('Skipped: ' . substr($destination, strlen(base_path()) + 1), 'vv');
        }
    }
    public function revamp($concepts) {
        foreach ($concepts as $concept) {
            $this->info('===> Revamping: ' . $concept);
            $this->makDirIfNotExist(base_path('concepts/' . $concept));
            $this->revampModel($concept);
            $this->revampController($concept);
            $this->revampMigration($concept);
            $this->revampSeeder($concept);
            $this->revampFactory($concept);
            $this->revampPolicy($concept);
            $this->revampRequests($concept);
            $this->revampViews($concept);
            $this->revampRoutes($concept);
        }
    }
    public function revampModel($concept) {
        $path = app_path('Models/' . $concept . '.php');
        $link = base_path('concepts/' . $concept . '/Model.php');
        $this->info('Revamping Model: ' . $concept);
        if (!file_exists($path)) {
            $this->info('Model not found: ' . $concept);
        } else {
            $this->linkFileIfNeeded($path, $link);
        }
    }
    public function revampController($concept) {
        $path = app_path('Http/Controllers/' . $concept . 'Controller.php');
        $link = base_path('concepts/' . $concept . '/Controller.php');
        $this->info('Revamping Controller: ' . $concept);
        if (!file_exists($path)) {
            $this->info('Controller not found: ' . $concept);
        } else {
            $this->linkFileIfNeeded($path, $link);
        }
    }
    public function revampMigration($concept) {
        $path = glob(database_path('migrations/*_create_' . Str::plural(Str::snake($concept)) . '_table.php'))[0];
        $link = base_path('concepts/' . $concept . '/migration.php');
        $this->info('Revamping Migration: ' . $concept);
        if (!file_exists($path)) {
            $this->info('Migration not found: ' . $concept);
        } else {
            $this->linkFileIfNeeded($path, $link);
        }
    }
    public function revampSeeder($concept) {
        $path = database_path('seeders/' . $concept . 'Seeder.php');
        $link = base_path('concepts/' . $concept . '/Seeder.php');
        $this->info('Revamping Seeder: ' . $concept);
        if (!file_exists($path)) {
            $this->info('Seeder not found: ' . $concept);
        } else {
            $this->linkFileIfNeeded($path, $link);
        }
    }
    public function revampFactory($concept) {
        $path = database_path('factories/' . $concept . 'Factory.php');
        $link = base_path('concepts/' . $concept . '/Factory.php');
        $this->info('Revamping Factory: ' . $concept);
        if (!file_exists($path)) {
            $this->info('Factory not found: ' . $concept);
        } else {
            $this->linkFileIfNeeded($path, $link);
        }
    }
    public function revampPolicy($concept) {
        $path = app_path('Policies/' . $concept . 'Policy.php');
        $link = base_path('concepts/' . $concept . '/Policy.php');
        $this->info('Revamping Policy: ' . $concept);
        if (!file_exists($path)) {
            $this->warn('Policy not found: ' . $concept, 'vv');
        } else {
            $this->linkFileIfNeeded($path, $link);
        }
    }
    public function revampRequests($concept) {
        $paths = glob(app_path('Http/Requests/*' . $concept . 'Request.php'));
        $this->info('Revamping Requests: ' . $concept);
        foreach ($paths as $path) {
            $name = basename($path);
            $name = str_replace($concept, '', $name);
            $link = base_path('concepts/' . $concept . '/' . $name);
            $this->linkFileIfNeeded($path, $link);
        }
    }
    public function revampViews($concept) {
        $path = resource_path('views/' . Str::plural(Str::snake($concept)));
        if (!file_exists($path)) {
            $path = resource_path('views/' . Str::snake($concept));
        }
        $link = base_path('concepts/' . $concept . '/views');
        $this->info('Revamping Views: ' . $path);
        if (!file_exists($path)) {
            $this->warn('Views not found: ' . $concept, 'vv');
        } else {
            $this->linkDirIfNeeded($path, $link);
        }
    }
    public function revampRoutes($concept) {
        $path = base_path('routes/' . $concept . '.php');
        $link = base_path('concepts/' . $concept . '/routes.php');
        $this->info('Revamping Routes: ' . $concept);
        if (!file_exists($path)) {
            $this->warn('Routes not found: ' . $concept, 'vv');
        } else {
            $this->linkFileIfNeeded($path, $link);
        }
    }
}
