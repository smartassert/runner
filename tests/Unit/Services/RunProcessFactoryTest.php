<?php

declare(strict_types=1);

namespace webignition\BasilCliRunner\Tests\Unit\Services;

use webignition\BasilCliRunner\Services\ProjectRootPathProvider;
use webignition\BasilCliRunner\Services\ResultPrinter\ResultPrinter;
use webignition\BasilCliRunner\Services\RunProcessFactory;
use webignition\BasilCliRunner\Tests\Unit\AbstractBaseTest;

class RunProcessFactoryTest extends AbstractBaseTest
{
    private RunProcessFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new RunProcessFactory(
            (new ProjectRootPathProvider())->get()
        );
    }

    public function testCreate()
    {
        $root = (new ProjectRootPathProvider())->get();
        $path = 'path/to/target';

        $process = $this->factory->create($path);

        $this->assertSame(
            sprintf(
                '%s/vendor/bin/phpunit -c %s/phpunit.run.xml --colors=always  --printer="%s" %s',
                $root,
                $root,
                ResultPrinter::class,
                $path
            ),
            $process->getCommandLine()
        );
    }
}
