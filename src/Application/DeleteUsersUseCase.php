<?php

namespace TicTacToe\Application;

use TicTacToe\Domain\User;
use TicTacToe\Domain\UserRepository;

final class DeleteUsersUseCase
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(User $user): void
    {
        $this->userRepository->delete($user);
    }
}