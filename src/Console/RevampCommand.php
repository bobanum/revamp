<?php

namespace Bobanum\Revamp\Console;

use Bobanum\Revamp\Concept;
use Illuminate\Console\Command;
use Bobanum\Revamp\Sources\GlobalSource;

class RevampCommand extends Command {
    use \Bobanum\Revamp\FilesTrait;
    public $asciiBox = [
        'single' => [
            '┌','┬','─','┐',
            '├','┼','─','┤',
            '│','│',' ','│',
            '└','┴','─','┘'
        ],
        'double' => [
            '╔','╦','═','╗',
            '╠','╬','═','╣',
            '║','║',' ','║',
            '╚','╩','═','╝'
        ],
        'bold' => [
            '┏','┳','━','┓',
            '┣','╋','━','┫',
            '┃','┃',' ','┃',
            '┗','┻','━','┛'
        ],
        'double-outside' => [
            '┌','╥','─','┐',
            '╞','╬','═','╡',
            '│','║',' ','│',
            '└','╨','─','┘'
        ],
        'double-horizontal' => [
            '┌','┬','─','┐',
            '╞','╪','═','╡',
            '│','│',' ','│',
            '└','┴','─','┘'
        ],
        'double-vertical' => [
            '┌','╥','─','┐',
            '├','╫','─','┤',
            '│','║',' ','│',
            '└','╨','─','┘'
        ],
        'single-horizontal' => [
            '╔','╦','═','╗',
            '╟','╫','─','╢',
            '║','║',' ','║',
            '╚','╩','═','╝'
        ],
        'single-vertical' => [
            '╔','╤','═','╗',
            '╠','╪','═','╣',
            '║','│',' ','║',
            '╚','╧','═','╝'
        ],
        'blocks' => [
            '▛','▀','▀','▜',
            '▌','▄','▄','▐',
            '▌','▐',' ','▐',
            '▙','▄','▄','▟'
        ],
    ];
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
        $this->header("Starting Revamping...", 'blocks');
        $this->makDirIfNotExist($this->revamp_path());
        $this->revampGlobal();
        $concepts = $this->getConcepts();
        $this->revamp($concepts);
        return 1;
    }
    public function header($text, $decoration = 'double') {
        $length = 80;
        $ch = $this->asciiBox[$decoration];
        $line = '';
        $line .= $ch[0]. str_repeat($ch[2], $length - 2) . $ch[3] . "\n";
        $line .= $ch[8]. str_pad($text, $length - 2, ' ', STR_PAD_BOTH) . $ch[11] . "\n";
        $line .= $ch[12]. str_repeat($ch[14], $length - 2) . $ch[15] . "\n";
        $this->info($line);
    }
    public function getConcepts() {
        // Get all the models
        return Concept::getConcepts();
    }
    public function revampGlobal() {
        $source = new GlobalSource();
        $source->revamp();
        return;
        // Link routes.php (api and web)
        $this->linkFileIfNeeded(base_path('routes/web.php'), $this->revamp_path('routes_web.php'));
        $this->linkFileIfNeeded(base_path('routes/api.php'), $this->revamp_path('routes_api.php'));
        // Link DatabaseSeeder.php
        $this->linkFileIfNeeded(database_path('seeders/DatabaseSeeder.php'), $this->revamp_path('DatabaseSeeder.php'));
    }
    public function revamp($concepts) {
        foreach ($concepts as $concept) {
            $concept = new Concept($concept, $this);
            $concept->revamp();
        }
    }
}
