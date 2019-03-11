<?php

declare(strict_types=1);

namespace TicTacToe\tests\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\DeleteUsersUseCase;
use TicTacToe\Infrastructure\UserRepositoryInMemory;

final class DeleteUsersUseCaseTest extends TestCase
{
    private $userRepositoryInMemory;

    public function setUp()
    {
        $this->userRepositoryInMemory = new UserRepositoryInMemory();
    }

    /**
     * @param string $id
     *
     * @dataProvider getUserIds
     */
    public function testItDeletesUsers(string $id)
    {
        $user = $this->userRepositoryInMemory->find($id);

        $deleteUsersUseCase = new DeleteUsersUseCase($this->userRepositoryInMemory);

        $deleteUsersUseCase->__invoke($user);

        $this->assertEmpty($this->userRepositoryInMemory->find($id));
    }

    public function getUserIds()
    {
        return [
            ['user1'],
            ['user2'],
        ];
    }
}
