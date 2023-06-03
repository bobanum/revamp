<?php

namespace Bobanum\Revamp\Sources;

class VueModelSource extends Source {
    use \Bobanum\Revamp\FilesTrait;

    public function revamp_name() {
        if (config('revamp.shorten_names', true)) {
            return "VueModel.js";
        }
        return 'Vue'.$this->concept->name . '.js';
    }
    static public function source_file_path($pattern) {
        $path = resource_path('js/models/' . $pattern . '.js');
        return $path;
    }
    public function revamp() {
        $path = $this->source_path();

        $link = $this->link_path();
        if (file_exists($path)) {
            $this->info('Revamping Vue Model','vv');
            $this->linkFileIfNeeded($path, $link);
        } else {
            $this->warn('No Vue model found','vvv');
        }
    }
}
