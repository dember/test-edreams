<?php

namespace TicTacToe\Application;

use TicTacToe\Domain\Game;
use TicTacToe\Domain\User;

final class StartNewGameUseCase
{
    /**
     * @param User $user1
     * @param User $user2
     *
     * @return Game
     */
    public function __invoke(User $user1, User $user2): Game
    {
        return new Game($user1, $user2);
    }
}