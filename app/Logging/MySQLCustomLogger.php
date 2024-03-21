<?php

namespace App\Logging;

use Monolog\Logger;

class MySQLCustomLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array<mixed>  $config
     */
    public function __invoke(array $config): Logger
    {
        $logger = new Logger('MySQLLoggingHandler');

        return $logger->pushHandler(new MySQLLoggingHandler());
    }
}
