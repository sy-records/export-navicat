<?php

namespace Luffy\ExportNavicat\Command;

use Inhere\Console\Command;
use Inhere\Console\IO\Input;
use Inhere\Console\IO\Output;
use Inhere\Console\Util\Show;
use Luffy\ExportNavicat\Connection;
use Toolkit\PFlag\FlagsParser;
use Toolkit\PFlag\FlagType;

class ConnectionCommand extends Command
{
    protected static string $name = 'connection';

    protected static string $desc = 'export the connection';

    public static function aliases(): array
    {
        return ['con', 'data'];
    }

    protected function configFlags(FlagsParser $fs): void
    {
        $fs->addOpt('file', 'f', 'the ncx file for decrypt', FlagType::STRING, true);
        $fs->addOpt('version', 'v', 'the navicat version', FlagType::INT, false, 12);
    }

    protected function execute(Input $input, Output $output)
    {
        $file = $this->flags->getOpt('file');
        $version = $this->flags->getOpt('version');

        if(!file_exists($file)) {
            $output->error('The file does not exist');
            return;
        }

        $conn = new Connection($file, $version);
        $connections = $conn->getConnections();
        foreach ($connections as $connection) {
            $title = "{$connection['name']}";
            Show::panel($connection, $title, ['ucFirst' => false]);
        }
    }
}