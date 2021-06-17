<?php

declare(strict_types=1);

namespace webignition\BasilCliRunner\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use webignition\BasilCliRunner\Services\BufferHandler;
use webignition\BasilCliRunner\Services\RunProcessFactory;
use webignition\SymfonyConsole\TypedInput\TypedInput;

class RunCommand extends Command
{
    public const OPTION_PATH = 'path';

    public const RETURN_CODE_INVALID_PATH = 100;
    public const RETURN_CODE_UNABLE_TO_RUN_PROCESS = 200;

    private const NAME = 'run';

    public function __construct(
        private RunProcessFactory $runProcessFactory
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Command description')
            ->addOption(
                self::OPTION_PATH,
                null,
                InputOption::VALUE_REQUIRED,
                'Absolute path to a test to run.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $typedInput = new TypedInput($input);

        $path = trim((string) $typedInput->getStringOption(RunCommand::OPTION_PATH));
        if (!is_file($path)) {
            return self::RETURN_CODE_INVALID_PATH;
        }

        $process = $this->runProcessFactory->create($path);
        $bufferHandler = new BufferHandler();

        $exitCode = $process->run(function ($type, $buffer) use ($output, $bufferHandler) {
            if (Process::OUT === $type) {
                $handledBuffer = $bufferHandler->handle($buffer);

                if (null !== $handledBuffer) {
                    $output->write($buffer);
                }
            }
        });

        return in_array($exitCode, [0, 1, 2])
            ? 0
            : self::RETURN_CODE_UNABLE_TO_RUN_PROCESS;
    }
}
