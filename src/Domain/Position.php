<?php

declare(strict_types = 1);

namespace TicTacToe\Domain;

use TicTacToe\Domain\Exception\InvalidArgumentAtPositionCreationException;

final class Position
{
    /**
     * @var int
     */
    private $x;
    /**
     * @var int
     */
    private $y;

    /**
     * Position constructor.
     *
     * @param int $x
     * @param int $y
     *
     * @throws InvalidArgumentAtPositionCreationException
     */
    public function __construct(int $x, int $y)
    {
        if ($x < 0 || $y < 0) {
            throw new InvalidArgumentAtPositionCreationException();
        }

        $this->x = $x;
        $this->y = $y;
    }
}