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
     * @param array $user1
     * @param array $user2
     *
     * @dataProvider getUsersInfo
     *
     * @throws \TicTacToe\Domain\Exception\NotUserTurnException
     */
   public function testItDoesAMove(array $user1, array $user2)
   {
       $startNewGameUseCase = new StartNewGameUseCase();

       $game = $startNewGameUseCase->__invoke(
           new User($user1['id'], $user1['name']),
           new User($user2['id'], $user2['name'])
       );

       $userDoingMoveUseCase = new UserDoingMoveUseCase();

       $userDoingMoveUseCase->__invoke(
           $game,
           new UserMovement($game->getFirstUser(), new Position(0, 0)
       ));

       $this->assertCount(1, $game->getMovementHistoric()->getMovements());
   }

    public function getUsersInfo()
    {
        return [
            [
                ['id'   => 'user1','name' => 'William'],
                ['id'    => 'user2','name' => 'Shakespeare']
            ]
        ];
    }
}
