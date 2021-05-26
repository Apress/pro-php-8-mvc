<?php

namespace Framework\Database\Command;

use Framework\Database\Factory;
use Framework\Database\Connection\Connection;
use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Connection\SqliteConnection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends Command
{
    protected static $defaultName = 'migrate';

    protected function configure()
    {
        $this
            ->setDescription('Migrates the database')
            ->setHelp('This command looks for all migration files and runs them');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $current = getcwd();
        $pattern = 'database/migrations/*.php';

        $paths = glob("{$current}/{$pattern}");

        if (count($paths) < 1) {
            $this->writeln('No migrations found');
            return Command::SUCCESS;
        }

        $connection = $this->connection();

        foreach ($paths as $path) {
            [$prefix, $file] = explode('_', $path);
            [$class, $extension] = explode('.', $file);

            require $path;

            $obj = new $class();
            $obj->migrate($connection);
        }
        
        return Command::SUCCESS;
    }

    private function connection(): Connection
    {
        $factory = new Factory();

        $factory->addConnector('mysql', function($config) {
            return new MysqlConnection($config);
        });

        $factory->addConnector('sqlite', function($config) {
            return new SqliteConnection($config);
        });

        $config = require getcwd() . '/config/database.php';

        return $factory->connect($config[$config['default']]);
    }
}
