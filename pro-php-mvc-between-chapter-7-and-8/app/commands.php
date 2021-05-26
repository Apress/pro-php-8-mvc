<?php

use App\Console\Commands\NameCommand;
use Framework\Database\Command\MigrateCommand;

return [
    MigrateCommand::class,
    NameCommand::class,
];
