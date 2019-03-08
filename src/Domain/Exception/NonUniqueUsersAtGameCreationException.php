<?php

namespace TicTacToe\Domain\Exception;

class NonUniqueUsersAtGameCreationException extends \Exception
{
    protected $message = 'First and second user must be different';
}