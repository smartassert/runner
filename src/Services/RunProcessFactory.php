<?php

declare(strict_types=1);

namespace webignition\BasilCliRunner\Services;

use Symfony\Component\Process\Process;
use webignition\BasilPhpUnitResultPrinter\ResultPrinter;

class RunProcessFactory
{
    public function __construct(
        private string $projectRootPath
    ) {}

    public function create(string $path): Process
    {
        return Process::fromShellCommandline($this->createPhpUnitCommand($path));
    }

    private function createPhpUnitCommand(string $path): string
    {
        $phpUnitExecutablePath = $this->projectRootPath . '/vendor/bin/phpunit';
        $phpUnitConfigurationPath = $this->projectRootPath . '/phpunit.run.xml';

        return $phpUnitExecutablePath
            . ' -c ' . $phpUnitConfigurationPath
            . ' --printer="' . ResultPrinter::class . '"'
            . ' --colors=always'
            . ' ' . $path;
    }
}
