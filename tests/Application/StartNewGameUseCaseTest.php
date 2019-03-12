<?php

declare(strict_types=1);

namespace TicTacToe\tests\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\StartNewGameUseCase;
use TicTacToe\Domain\Exception\NonUniqueUsersAtGameCreationException;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\User;

final class StartNewGameUseCaseTest extends TestCase
{
    /**
     * @param array $user1
     * @param array $user2
     *
     * @dataProvider getUsersInfo
     *
     * @throws NonUniqueUsersAtGameCreationException
     */
    public function testItStartNewGame(array $user1, array $user2)
    {
        $startNewGameUseCase = new StartNewGameUseCase();

        $game = $startNewGameUseCase->__invoke(
            new User($user1['id'], $user1['name']),
            new User($user2['id'], $user2['name'])
        );

        $this->assertInstanceOf(Game::class, $game);
    }

    public function getUsersInfo(): array
    {
        return [
            [
                ['id' => 'user1', 'name' => 'William'],
                ['id' => 'user2', 'name' => 'Shakespeare']
            ]
        ];
    }
}
