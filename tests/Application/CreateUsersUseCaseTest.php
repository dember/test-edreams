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
     * @param string $name
     *
     * @dataProvider getUserNames
     */
   public function testItCreateUsers(string $name)
   {
       $userRepository = $this->createMock(UserRepositoryInMemory::class);

       $userRepository->expects($this->once())
           ->method('create')
           ->with($this->isType('string'));

       $createUsersUseCase = new CreateUsersUseCase($userRepository);

       $user = $createUsersUseCase->__invoke($name);

       $this->assertInstanceOf(User::class, $user);
   }

    public function getUserNames()
    {
        return [
            ['William'],
            ['Shakespeare'],
        ];
    }
}
