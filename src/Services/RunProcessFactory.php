<?php

declare(strict_types=1);

namespace webignition\BasilCliRunner\Services;

use Symfony\Component\Process\Process;

class RunProcessFactory
{
    public function __construct(
        private string $projectRootPath
    ) {}

    public function create(string $path): Process
    {
        $process = Process::fromShellCommandline($this->createPhpUnitCommand($path));
        $process->setTimeout(null);
        $process->setIdleTimeout(null);

        return $process;
    }

    private function createPhpUnitCommand(string $path): string
    {
        $phpUnitExecutablePath = $this->projectRootPath . '/vendor/bin/phpunit';
        $phpUnitConfigurationPath = $this->projectRootPath . '/phpunit.run.xml';

        return $phpUnitExecutablePath
            . ' -c ' . $phpUnitConfigurationPath
            . ' --colors=always'
            . ' ' . $path;
    }
}
