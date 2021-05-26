<?php

namespace Framework\Filesystem\Driver;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;

class LocalDriver extends Driver
{
    protected function connect()
    {
        $adapter = new LocalFilesystemAdapter($this->config['path']);
        $this->filesystem = new Filesystem($adapter);
    }
}
