<?php

namespace App\Adapters\ViewModels;

use App\Domain\Interfaces\ViewModel;
use Illuminate\Console\Command;

/**
 * View model for CLI command handling
 */
class CliViewModel implements ViewModel
{
    /**
     * @param  \Closure  $handler
     */
    public function __construct(
        private \Closure $handler
    ) {
    }

    /**
     * @param  Command  $command
     * @return mixed
     */
    public function handle(Command $command): mixed
    {
        return $this->handler->call($command, $command);
    }
}
