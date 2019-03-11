<?php

namespace TicTacToe\Domain;

interface GameRepository
{
    public function create(User $user1, User $user2): Game;

    public function delete(Game $game): void;

    public function find(string $id): ?Game;
}