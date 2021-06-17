<?php

declare(strict_types=1);

namespace webignition\BasilCliRunner\Tests\Unit\Services;

use webignition\BasilCliRunner\Services\BufferHandler;
use webignition\BasilCliRunner\Tests\Unit\AbstractBaseTest;

class BufferHandlerTest extends AbstractBaseTest
{
    private BufferHandler $bufferHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bufferHandler = new BufferHandler();
    }

    /**
     * @dataProvider handleDataProvider
     *
     * @param string[]           $lines
     * @param array<null|string> $expectedOutput
     */
    public function testHandle(array $lines, array $expectedOutput)
    {
        $output = [];

        foreach ($lines as $line) {
            $output[] = $this->bufferHandler->handle($line);
        }

        self::assertSame($expectedOutput, $output);
    }

    public function handleDataProvider(): array
    {
        return [
            'empty' => [
                'lines' => [],
                'expectedOutput' => [],
            ],
            'no yaml document separator' => [
                'lines' => [
                    'one',
                    'two',
                    'three',
                ],
                'expectedOutput' => [
                    null,
                    null,
                    null,
                ],
            ],
            'has yaml document separator as entire line content' => [
                'lines' => [
                    'one',
                    '---',
                    'two',
                    'three',
                ],
                'expectedOutput' => [
                    null,
                    '---',
                    'two',
                    'three',
                ],
            ],
            'has yaml document separator as partial line content' => [
                'lines' => [
                    'one',
                    '---' . "\n" . 'one.one',
                    'two',
                    'three',
                ],
                'expectedOutput' => [
                    null,
                    '---' . "\n" . 'one.one',
                    'two',
                    'three',
                ],
            ],
        ];
    }
}
