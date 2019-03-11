<?php

declare(strict_types=1);

namespace TicTacToe\tests\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\CreateUsersUseCase;
use TicTacToe\Infrastructure\UserRepositoryInMemory;

final class CreateUsersUseCaseTest extends TestCase
{
    private $userRepositoryInMemory;

    public function setUp()
    {
        $this->userRepositoryInMemory = new UserRepositoryInMemory();
    }

    /**
     * @param string $id
     * @param string $name
     *
     * @dataProvider getUserNames
     */
   public function testItCreateUsers(string $id, string $name)
   {
       $userNotYetCreated = $this->userRepositoryInMemory->find($id);

       $createUsersUseCase = new CreateUsersUseCase($this->userRepositoryInMemory);

       $createUsersUseCase->__invoke($id, $name);

       $userCreated = $this->userRepositoryInMemory->find($id);

       $this->assertNotEquals($userNotYetCreated, $userCreated);
   }

    public function getUserNames()
    {
        return [
            ['user3', 'William'],
        ];
    }
}
