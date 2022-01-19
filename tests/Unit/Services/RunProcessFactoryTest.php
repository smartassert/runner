<?php

declare(strict_types=1);

namespace webignition\BasilCliRunner\Tests\Unit\Services;

use webignition\BasilCliRunner\Services\RunProcessFactory;
use webignition\BasilCliRunner\Tests\Unit\AbstractBaseTest;
use webignition\BasilPhpUnitResultPrinter\ResultPrinter;

class RunProcessFactoryTest extends AbstractBaseTest
{
    private RunProcessFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new RunProcessFactory((string) getcwd());
    }

    /**
     * @dataProvider createDataProvider
     */
    public function testCreate(string $path, string $expectedCommand): void
    {
        $process = $this->factory->create($path);

        self::assertSame($expectedCommand, $process->getCommandLine());
    }

    /**
     * @return array<mixed>
     */
    public function createDataProvider(): array
    {
        $root = (string) getcwd();
        $path = 'path/to/target';

        return [
            'default' => [
                'path' => 'path/to/target',
                'expectedCommand' => sprintf(
                    '%s/vendor/bin/phpunit -c %s/phpunit.run.xml --printer="%s" --colors=always %s',
                    $root,
                    $root,
                    ResultPrinter::class,
                    $path
                ),
            ],
        ];
    }
}
