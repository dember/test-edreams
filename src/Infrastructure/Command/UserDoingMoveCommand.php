<?php

namespace TicTacToe\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\Application\StartNewGameUseCase;
use TicTacToe\Application\UserDoingMoveUseCase;
use TicTacToe\Domain\Exception\GameAlreadyFinishedException;
use TicTacToe\Domain\Exception\NotUserTurnException;
use TicTacToe\Domain\Position;
use TicTacToe\Domain\User;
use TicTacToe\Domain\UserMovement;
use TicTacToe\Infrastructure\GameRepositoryInMemory;
use TicTacToe\Infrastructure\UserRepositoryInMemory;

class UserDoingMoveCommand extends Command
{
    protected static $defaultName = 'tictactoe:game-move';

    private $gameRepositoryInMemory;
    private $userRepositoryInMemory;
    private $userDoingMoveUseCase;

    public function __construct(
        GameRepositoryInMemory $gameRepositoryInMemory,
        UserRepositoryInMemory $userRepositoryInMemory,
        UserDoingMoveUseCase $userDoingMoveUseCase
    )
    {
        parent::__construct();

        $this->userRepositoryInMemory = $userRepositoryInMemory;

        $this->gameRepositoryInMemory = $gameRepositoryInMemory;

        $this->userDoingMoveUseCase = $userDoingMoveUseCase;
    }

    protected function configure()
    {
        $this
            ->setDescription('Make a Movement in a Game.')

            ->setHelp('This command allows you to make a Movement in a Game by a User')

            ->addArgument('user_id', InputArgument::REQUIRED,'User identifier')

            ->addArgument('game_id', InputArgument::REQUIRED,'Game identifier')

            ->addArgument('X coordinate', InputArgument::REQUIRED,'X Position coordinate')

            ->addArgument('Y coordinate', InputArgument::REQUIRED,'Y Position coordinate')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     * @throws NotUserTurnException
     * @throws GameAlreadyFinishedException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $game = $this->gameRepositoryInMemory->find($input->getArgument('game_id'));
        $user = $this->userRepositoryInMemory->find($input->getArgument('user_id'));

        if (is_null($game) || is_null($user)) {
            $output->writeln([
                'Game or User Not Found',
                '=========================',
                '',
            ]);
        } else {
            $this->userDoingMoveUseCase->__invoke(
                $game, new UserMovement(
                    $user,
                    new Position(
                        $input->getArgument('X coordinate'),
                        $input->getArgument('Y coordinate')
                    )
                )
            );

            $output->writeln([
                'Game Movement successfully executed',
                '=========================',
                '',
            ]);
        }
    }
}