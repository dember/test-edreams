<?php

declare(strict_types=1);

namespace TicTacToe\tests\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\CreateUsersUseCase;
use TicTacToe\Domain\User;
use TicTacToe\Infrastructure\UserRepositoryInMemory;

final class CreateUsersUseCaseTest extends TestCase
{
    /**
     * @param string $id
     * @param string $name
     *
     * @dataProvider getUserNames
     */
   public function testItCreateUsers(string $id, string $name)
   {
       $userRepository = $this->createMock(UserRepositoryInMemory::class);

       $userRepository->expects($this->once())
           ->method('create')
           ->with($this->isType('string'));

       $createUsersUseCase = new CreateUsersUseCase($userRepository);

       $user = $createUsersUseCase->__invoke($id, $name);

       $this->assertInstanceOf(User::class, $user);
   }

    public function getUserNames()
    {
        return [
            ['user1', 'William'],
            ['user2', 'Shakespeare'],
        ];
    }
}
