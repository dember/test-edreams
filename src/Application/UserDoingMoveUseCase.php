<?php

namespace TicTacToe\Application;

use TicTacToe\Domain\Exception\NotUserTurnException;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\Movement;

final class UserDoingMoveUseCase
{
    /**
     * @param Game     $game
     * @param Movement $movement
     *
     * @throws NotUserTurnException
     */
    public function __invoke(Game $game, Movement $movement): void
    {
        $game->move($movement);
    }
}