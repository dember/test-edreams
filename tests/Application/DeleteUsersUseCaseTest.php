<?php

declare(strict_types=1);

namespace TicTacToe\tests\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\DeleteUsersUseCase;
use TicTacToe\Domain\User;
use TicTacToe\Infrastructure\UserRepositoryInMemory;

final class DeleteUsersUseCaseTest extends TestCase
{
    /**
     * @param string $id
     * @param string $name
     *
     * @dataProvider getUserNames
     */
   public function testItDeletesUsers(string $id, string $name)
   {
       $user = new User($id, $name);

       $userRepository = $this->createMock(UserRepositoryInMemory::class);

       $userRepository->expects($this->once())
           ->method('delete')
           ->with($this->isInstanceOf(User::class));

       $deleteUsersUseCase = new DeleteUsersUseCase($userRepository);

       $deleteUsersUseCase->__invoke($user);
   }

    public function getUserNames()
    {
        return [
            ['user1', 'William'],
            ['user2', 'Shakespeare'],
        ];
    }
}
