<?php

declare(strict_types=1);

namespace TicTacToe\tests\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\StartNewGameUseCase;
use TicTacToe\Application\UserDoingMoveUseCase;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\Position;
use TicTacToe\Domain\User;
use TicTacToe\Domain\UserMovement;

final class UserDoingMoveUseCaseTest extends TestCase
{
    /**
     * @param string $name1
     * @param string $name2
     *
     * @dataProvider getUserNames
     *
     * @throws \TicTacToe\Domain\Exception\NotUserTurnException
     */
   public function testItStartNewGame(string $name1, string $name2)
   {
       $startNewGameUseCase = new StartNewGameUseCase();

       $game = $startNewGameUseCase->__invoke(new User($name1), new User($name2));

       $userDoingMoveUseCase = new UserDoingMoveUseCase();

       $userDoingMoveUseCase->__invoke(
           $game,
           new UserMovement($game->getFirstUser(), new Position(0, 0)
       ));

       $this->assertCount(1, $game->getMovementHistoric()->getMovements());
   }

    public function getUserNames()
    {
        return [
            ['William', 'Shakespeare'],
        ];
    }
}
