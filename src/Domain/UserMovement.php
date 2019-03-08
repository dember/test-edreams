<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

final class UserMovement implements Movement
{
    private $user;

    private $position;

    public function __construct(User $user, Position $position)
    {
        $this->user     = $user;
        $this->position = $position;
    }

    public function getInitiator(): User
    {
        return $this->user;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }
}