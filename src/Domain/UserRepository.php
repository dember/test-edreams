<?php

namespace TicTacToe\Domain;

interface UserRepository
{
    public function create(string $name): User;

    public function delete(User $user): void;
}