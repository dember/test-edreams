<?php

declare(strict_types = 1);

namespace TicTacToe\Domain;

interface Movement
{
    public function getInitiator();

    public function getPosition();
}
