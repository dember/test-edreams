<?php

namespace TicTacToe\Application;

use TicTacToe\Domain\Game;

final class CheckForGameFinishedWinnerUseCase
{
    public function __invoke(Game $game): array
    {
        $game->updateGameStatus();

        return [
            'winner'      => $game->getWinner(),
            'hasFinished' => $game->hasFinished()
        ];
    }
}