<?php

declare(strict_types=1);

namespace TicTacToe\tests\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\CheckForGameFinishedWinnerUseCase;
use TicTacToe\Domain\Exception\NonUniqueUsersAtGameCreationException;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\User;

final class CheckForGameFinishedWinnerUseCaseTest extends TestCase
{
    /**
     * @throws NonUniqueUsersAtGameCreationException
     */
    public function testItUpdatesGameAndReturnsInfo()
    {
        $checkForGameFinishedWinnerUseCase = new CheckForGameFinishedWinnerUseCase();

        $game = new Game(
            new User('user1', 'William'),
            new User('user2', 'Shakespeare')
        );

        $info = $checkForGameFinishedWinnerUseCase->__invoke($game);

        $this->assertNotEmpty($info);
    }
}
