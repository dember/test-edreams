<?php

namespace TicTacToe\Infrastructure;

use TicTacToe\Domain\User;
use TicTacToe\Domain\UserRepository;

class UserRepositoryInMemory implements UserRepository
{
    public $users = [];

    public function __construct()
    {
        $this->users['user1'] = new User('user1', 'William');
        $this->users['user2'] = new User('user2', 'Shakespeare');
    }

    public function create(string $id, string $name): User
    {
        $user = new User($id, $name);

        $this->users[$id] = $user;

        return $user;
    }

    public function delete(User $user): void
    {
        unset($this->users[$user->getId()]);
    }

    public function find(string $id): ?User
    {
        return array_key_exists($id, $this->users) ? $this->users[$id] : null;
    }
}