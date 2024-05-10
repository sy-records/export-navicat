<?php

namespace Luffy\ExportNavicat\Command;

use Inhere\Console\Command;
use Inhere\Console\IO\Input;
use Inhere\Console\IO\Output;
use Luffy\ExportNavicat\Password;
use Toolkit\PFlag\FlagsParser;
use Toolkit\PFlag\FlagType;

class DecryptCommand extends Command
{
    protected static string $name = 'decrypt';

    protected static string $desc = 'decrypt the password';

    public static function aliases(): array
    {
        return ['de', 'decode'];
    }

    protected function configFlags(FlagsParser $fs): void
    {
        $fs->addOpt('password', 'pwd', 'the password for decrypt', FlagType::STRING, true);
        $fs->addOpt('version', 'v', 'the navicat version', FlagType::INT, false, 12);
    }

    protected function execute(Input $input, Output $output)
    {
        $password = $this->flags->getOpt('password');
        $version = $this->flags->getOpt('version');
        $navicatPassword = new Password($version);

        $decrypt = $navicatPassword->decrypt($password);
        $output->write("<success>{$decrypt}</success>");
    }
}