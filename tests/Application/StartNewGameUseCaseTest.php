<?php

declare(strict_types=1);

namespace TicTacToe\tests\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\Application\StartNewGameUseCase;
use TicTacToe\Domain\Game;
use TicTacToe\Domain\User;

final class StartNewGameUseCaseTest extends TestCase
{
    /**
     * @param string $name1
     * @param string $name2
     *
     * @dataProvider getUserNames
     */
   public function testItStartNewGame(string $name1, string $name2)
   {
       $startNewGameUseCase = new StartNewGameUseCase();

       $game = $startNewGameUseCase->__invoke(new User($name1), new User($name2));

       $this->assertInstanceOf(Game::class, $game);
   }

    public function getUserNames()
    {
        return [
            ['William', 'Shakespeare'],
        ];
    }
}
