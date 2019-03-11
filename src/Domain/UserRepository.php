<?php

namespace TicTacToe\Domain;

interface UserRepository
{
    public function create(string $id, string $name): User;

    public function delete(User $user): void;

    public function find(string $id): ?User;
}