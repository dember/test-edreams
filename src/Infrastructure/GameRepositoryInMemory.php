<?php

namespace TicTacToe\Infrastructure;

use TicTacToe\Domain\Exception\NonUniqueUsersAtGameCreationException;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\GameRepository;
use TicTacToe\Domain\User;

class GameRepositoryInMemory implements GameRepository
{
    private $games = [];

    /**
     * GameRepositoryInMemory constructor.
     * @throws NonUniqueUsersAtGameCreationException
     */
    public function __construct()
    {
        $user1 = new User('user1', 'William');
        $user2 = new User('user2', 'Shakespeare');

        $this->games['game0'] = new Game($user1, $user2);
        $this->games['game1'] = new Game($user1, $user2);
    }

    /**
     * @param User $user1
     * @param User $user2
     *
     * @return Game
     * @throws NonUniqueUsersAtGameCreationException
     */
    public function create(User $user1, User $user2): Game
    {
        $game = new Game($user1, $user2);

        $this->games['game'.(count($this->games))] = $game;

        return $game;
    }

    public function delete(Game $game): void
    {
        unset($this->games[$game->getId()]);
    }

    public function find(string $id): ?Game
    {
        return array_key_exists($id, $this->games) ? $this->games[$id] : null;
    }
}