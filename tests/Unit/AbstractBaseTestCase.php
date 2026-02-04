<?php

declare(strict_types=1);

namespace webignition\BasilCliRunner\Tests\Unit;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

abstract class AbstractBaseTestCase extends TestCase
{
    use MockeryPHPUnitIntegration;
}
