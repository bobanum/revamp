<?php

namespace Bobanum\Revamp\Console;

use Illuminate\Support\Str;

class RevampRefreshCommand extends RevampCommand {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revamp:extra';
    protected $aliases = [
        'revamp:x',
    ];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reRevamp the application (removes the "concepts" folder and re-revamps)';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle() {
        Artisan::call('composer update');
        $db = str_replace('\\','/',glob(database_path('*.{sqlite,db}'))[0]);
        file_put_contents(base_path('.env', <<<EOT
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:GwJEAEl+JjietYAvbHsDEdNLYYL7WTOvHnVZUIlW2Ig=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE="{$db}"
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="\${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="\${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="\${PUSHER_APP_CLUSTER}"

EOT
    ));
        return 1;
    }
}
