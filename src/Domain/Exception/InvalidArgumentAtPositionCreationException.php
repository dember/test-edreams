<?php

namespace TicTacToe\Domain\Exception;

class InvalidArgumentAtPositionCreationException extends \Exception
{
    protected $message = 'Arguments must be greater than 0';
}