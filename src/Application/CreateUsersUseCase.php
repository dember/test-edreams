<?php

namespace TicTacToe\Application;

use TicTacToe\Domain\User;
use TicTacToe\Domain\UserRepository;

final class CreateUsersUseCase
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(string $name): User
    {
        return $this->userRepository->create($name);
    }
}