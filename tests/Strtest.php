<?php

declare(strict_types=1);

namespace Saidqb\CorePhp\Tests;

use PHPUnit\Framework\TestCase;
use Saidqb\CorePhp\Lib\Str;

/**
 * @covers \Saidqb\CorePhp\Lib\Str
 * running test
 * ./vendor/bin/phpunit tests/Strtest.php
 */
class Strtest extends TestCase
{
    public function testSample()
    {
        $t = new Str('Test');
        $this->assertSame('TEST', $t->toUpper('test'));
    }
}
