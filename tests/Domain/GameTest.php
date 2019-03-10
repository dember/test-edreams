<?php

declare(strict_types=1);

namespace TicTacToe\tests\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Domain\Exception\NonUniqueUsersAtGameCreationException;
use TicTacToe\Domain\Exception\NotUserTurnException;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\Position;
use TicTacToe\Domain\User;
use TicTacToe\Domain\UserMovement;

final class GameTest extends TestCase
{
    public function testItDoesNotAllowToCreateAGameWithTheSameUser()
    {
        $user1 = new User();

        $this->expectException(NonUniqueUsersAtGameCreationException::class);

        new Game($user1, $user1);
    }

    public function testItDoesNotAllowAUserToMoveWhenIsNotHisTurn()
    {
        $user1 = new User();
        $user2 = new User();

        $game = new Game($user1, $user2);

        $this->expectException(NotUserTurnException::class);

        $game->move(new UserMovement($user1, new Position(0, 0)));
        $game->move(new UserMovement($user1, new Position(0, 1)));
    }

    public function testItHasNoUserMovementsByDefault()
    {
        $user1 = new User();
        $user2 = new User();

        $game = new Game($user1, $user2);

        $this->assertEmpty($game->getMovementHistoric()->getMovements());
    }

    public function testItAddsMovements()
    {
        $user1 = new User();
        $user2 = new User();

        $game = new Game($user1, $user2);

        $game->move(new UserMovement($user1, new Position(0, 0)));

        $this->assertCount(1, $game->getMovementHistoric()->getMovements());
    }
}
