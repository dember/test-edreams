<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

use TicTacToe\Domain\Exception\NonUniqueUsersAtGameCreationException;
use TicTacToe\Domain\Exception\NotUserTurnException;

final class Game
{
    private $hasFinished;

    private $movementHistoric;

    private $winner;

    private $user1;

    private $user2;

    /**
     * Game constructor.
     *
     * @param User $user1
     * @param User $user2
     *
     * @throws NonUniqueUsersAtGameCreationException
     */
    public function __construct(User $user1, User $user2)
    {
        if ($user1 === $user2) {
            throw new NonUniqueUsersAtGameCreationException();
        }

        $this->hasFinished = false;
        $this->winner      = null;
        $this->user1       = $user1;
        $this->user2       = $user2;
        $this->movementHistoric = new MovementHistoric();
    }

    /**
     * @param Movement $movement
     *
     * @throws NotUserTurnException
     */
    public function move(Movement $movement): void
    {
        $lastMovement = $this->movementHistoric->getLastMovement();

        if (!is_null($lastMovement) && $lastMovement->getInitiator() === $movement->getInitiator()) {
            throw new NotUserTurnException();
        }

        $this->movementHistoric->addMovement($movement);
    }

    public function getMovementHistoric(): MovementHistoric
    {
        return $this->movementHistoric;
    }

    public function getFirstUser(): User
    {
        return $this->user1;
    }

    public function getSecondUser(): User
    {
        return $this->user2;
    }
}