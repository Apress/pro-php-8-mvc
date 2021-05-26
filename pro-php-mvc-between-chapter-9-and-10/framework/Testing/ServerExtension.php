<?php

namespace Framework\Testing;

use PHPUnit\Runner\BeforeFirstTestHook;
use PHPUnit\Runner\AfterLastTestHook;
use Symfony\Component\Process\Process;

final class ServerExtension implements BeforeFirstTestHook, AfterLastTestHook
{
    private Process $process;
    private bool $startedServer = false;

    private function startServer()
    {
        if ($this->serverIsRunning()) {
            $this->startedServer = false;
            return;
        }

        $this->startedServer = true;

        $base = app('paths.base');
        $separator = DIRECTORY_SEPARATOR;

        $this->process = new Process([
            PHP_BINARY,
            "{$base}{$separator}command.php",
            "serve"
        ], $base);

        $this->process->start(function($type, $buffer) {
            print $buffer;
        });
    }

    private function serverIsRunning()
    {
        $connection = @fsockopen(
            env('APP_HOST', '127.0.0.1'),
            env('APP_PORT', '8000'),
        );

        if (is_resource($connection)) {
            fclose($connection);
            return true;
        }
        
        return false;
    }

    private function stopServer()
    {
        if ($this->startedServer) {
            $this->process->signal(SIGTERM);
        }
    }

    public function executeBeforeFirstTest(): void
    {
        $this->startServer();
    }

    public function executeAfterLastTest(): void
    {
        $this->stopServer();
    }
}
