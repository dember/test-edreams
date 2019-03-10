<?php

namespace TicTacToe\Domain;

interface UserRepository
{
    public function create(): User;

    public function delete(User $user): void;
}