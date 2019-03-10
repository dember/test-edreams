<?php

namespace TicTacToe\Infrastructure;

use TicTacToe\Domain\User;
use TicTacToe\Domain\UserRepository;

class UserRepositoryInMemory implements UserRepository
{
    public function create(string $name): User
    {
        $user = new User($name);

        return $user;
    }

    public function delete(User $user): void
    {
        unset($user);
    }
}