<?php

namespace App\Logging;

use Illuminate\Support\Facades\DB;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\LogRecord;

class MySQLLoggingHandler extends AbstractProcessingHandler
{
    /**
     * Reference:
     * https://github.com/markhilton/monolog-mysql/blob/master/src/Logger/Monolog/Handler/MysqlHandler.php
     */
    private string $table;

    public function __construct($level = Level::Info, $bubble = true)
    {
        $this->table = 'action_log';
        parent::__construct($level, $bubble);
    }

    protected function write(LogRecord $record): void
    {
        $data = [
            'message' => $record['message'],
            'context' => json_encode($record['context']),
            'level' => $record['level'],
            'level_name' => $record['level_name'],
            'channel' => $record['channel'],
            'record_datetime' => $record['datetime']->format('Y-m-d H:i:s'),
            'extra' => json_encode($record['extra']),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        DB::connection()->table($this->table)->insert($data);
    }
}
