<?php

declare(strict_types = 1);

namespace TicTacToe\Domain;

class User
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}