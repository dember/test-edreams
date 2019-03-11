<?php

declare(strict_types=1);

namespace TicTacToe\Domain;

use TicTacToe\Domain\Exception\GameAlreadyFinishedException;
use TicTacToe\Domain\Exception\NonUniqueUsersAtGameCreationException;
use TicTacToe\Domain\Exception\NotUserTurnException;

final class Game
{
    const GAME_MATRIX = 3;

    const STATUS_STARTED = 'started';
    const STATUS_FINISHED = 'finished';
    const STATUS_FINISHED_DRAW = 'finished_draw';

    private $id;

    private $status;

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

        $this->status           = self::STATUS_STARTED;
        $this->winner           = null;
        $this->user1            = $user1;
        $this->user2            = $user2;
        $this->movementHistoric = new MovementHistoric();
    }

    /**
     * @param Movement $movement
     *
     * @throws GameAlreadyFinishedException
     * @throws NotUserTurnException
     */
    public function move(Movement $movement): void
    {
        $lastMovement = $this->movementHistoric->getLastMovement();

        if ($this->status !== self::STATUS_STARTED) {
            throw new GameAlreadyFinishedException();
        }

        if (!is_null($lastMovement) && $lastMovement->getInitiator() === $movement->getInitiator()) {
            throw new NotUserTurnException();
        }

        $this->movementHistoric->addMovement($movement);

        $this->updateGameStatus();
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

    public function getWinner(): ?User
    {
        return $this->winner;
    }

    public function hasFinished(): bool
    {
        return $this->status !== self::STATUS_STARTED;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function updateGameStatus(): void
    {
        $firstPlayerMatrix = array_fill(
            0,
            self::GAME_MATRIX,
            array_fill(0, self::GAME_MATRIX, 0)
        );

        $secondPlayerMatrix = array_fill(
            0,
            self::GAME_MATRIX,
            array_fill(0, self::GAME_MATRIX, 0)
        );

        $movements = $this->getMovementHistoric()->getMovements();

        foreach ($movements as $key => $movement) {
            if ($key % 2 == 0) {
                $firstPlayerMatrix[$movement->getPosition()->getX()][$movement->getPosition()->getY()] = 1;
            } else {
                $secondPlayerMatrix[$movement->getPosition()->getX()][$movement->getPosition()->getY()] = 1;
            }
        }

        $this->checkForWinnerInPlayerMatrix($firstPlayerMatrix, $this->user1);
        $this->checkForWinnerInPlayerMatrix($secondPlayerMatrix, $this->user2);
        $this->checkForDraw($firstPlayerMatrix, $secondPlayerMatrix);
    }

    /**
     * @param $playerMatrix
     * @param $user
     */
    private function checkForWinnerInPlayerMatrix($playerMatrix, User $user): void
    {
        $totalRow    = 0;
        $totalColumn = 0;

        for ($i = 0; $i < self::GAME_MATRIX; ++$i) {
            for ($j = $i; $j < self::GAME_MATRIX; ++$j) {
                $totalRow    += $playerMatrix[$i][$j];
                $totalColumn += $playerMatrix[$j][$i];
            }

            if ($totalRow === self::GAME_MATRIX || $totalColumn === self::GAME_MATRIX) {
                $this->status = self::STATUS_FINISHED;
                $this->winner = $user;
            }

            $totalRow    = 0;
            $totalColumn = 0;
        }


        $firstDiagonal  = $playerMatrix[0][0] + $playerMatrix[1][1] + $playerMatrix[2][2];
        $secondDiagonal = $playerMatrix[2][0] + $playerMatrix[1][1] + $playerMatrix[0][2];

        if ($firstDiagonal === self::GAME_MATRIX || $secondDiagonal === self::GAME_MATRIX) {
            $this->status = self::STATUS_FINISHED;
            $this->winner = $user;
        }
    }

    /**
     * @param $firstPlayerMatrix
     * @param $secondPlayerMatrix
     */
    private function checkForDraw($firstPlayerMatrix, $secondPlayerMatrix): void
    {
        if (is_null($this->winner)) {
            $totalMoves = 0;

            for ($i = 0; $i < self::GAME_MATRIX; $i++) {
                $totalMoves = array_sum(
                    array_merge($firstPlayerMatrix[$i], $secondPlayerMatrix[$i])
                );
            }

            if ($totalMoves === self::GAME_MATRIX * self::GAME_MATRIX) {
                $this->status = self::STATUS_FINISHED_DRAW;
            }
        }
    }


}