<?php

namespace Laraflow\Laraflow\Commands;

use Illuminate\Console\Command;

class LaraflowCommand extends Command
{
    public $signature = 'laraflow';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
