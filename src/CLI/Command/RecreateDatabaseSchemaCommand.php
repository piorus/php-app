<?php
declare(strict_types=1);

namespace CLI\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RecreateDatabaseSchemaCommand extends Command
{
    protected static $defaultName = 'app:db:recreate';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $databaseAdapter = new \Database\DatabaseAdapter();
    }
}