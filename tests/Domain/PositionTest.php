<?php

declare(strict_types=1);

namespace TicTacToe\tests\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\Exception\InvalidArgumentAtPositionCreationException;
use TicTacToe\Domain\Position;

final class PositionTest extends TestCase
{
    public function testItHasValidArguments()
    {
        $this->expectException(InvalidArgumentAtPositionCreationException::class);

        new Position(-1, 0);
    }
}
