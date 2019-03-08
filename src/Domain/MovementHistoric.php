<?php

namespace TicTacToe\Domain;

final class MovementHistoric
{
    /**
     * @var array | Movement[]
     */
    protected $movements;

    public function __construct()
    {
        $this->movements = [];
    }

    /**
     * @param Movement $movement
     */
    public function addMovement(Movement $movement)
    {
        $this->movements[] = $movement;
    }

    /**
     * @return null|Movement
     */
    public function getLastMovement(): ?Movement
    {
        return $this->movements[count($this->movements)-1] ?? null;
    }

    public function getMovements()
    {
        return $this->movements;
    }
}