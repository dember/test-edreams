<?php

declare(strict_types=1);

namespace TicTacToe\tests\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\UserDoingMoveUseCase;
use TicTacToe\Domain\Exception\GameAlreadyFinishedException;
use TicTacToe\Domain\Exception\NotUserTurnException;
use TicTacToe\Domain\Position;
use TicTacToe\Domain\UserMovement;
use TicTacToe\Infrastructure\GameRepositoryInMemory;

final class UserDoingMoveUseCaseTest extends TestCase
{
    private $gameRepositoryInMemory;

    public function setUp()
    {
        $this->gameRepositoryInMemory = new GameRepositoryInMemory();
    }

    /**
     * @throws GameAlreadyFinishedException
     * @throws NotUserTurnException
     */
    public function testItDoesAMove()
    {
        $game = $this->gameRepositoryInMemory->find('game0');

        $userDoingMoveUseCase = new UserDoingMoveUseCase();

        $userDoingMoveUseCase->__invoke(
            $game,
            new UserMovement($game->getFirstUser(), new Position(0, 0)
            ));

        $this->assertCount(1, $game->getMovementHistoric()->getMovements());
    }
}
