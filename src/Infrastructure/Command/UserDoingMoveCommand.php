<?php

namespace TicTacToe\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\Application\StartNewGameUseCase;
use TicTacToe\Application\UserDoingMoveUseCase;
use TicTacToe\Domain\Exception\NotUserTurnException;
use TicTacToe\Domain\Position;
use TicTacToe\Domain\User;
use TicTacToe\Domain\UserMovement;

class UserDoingMoveCommand extends Command
{
    protected static $defaultName = 'tictactoe:game-move';

    private $startNewGameUseCase;
    private $userDoingMoveUseCase;

    public function __construct(StartNewGameUseCase $startNewGameUseCase, UserDoingMoveUseCase $userDoingMoveUseCase)
    {
        parent::__construct();

        $this->startNewGameUseCase  = $startNewGameUseCase;

        $this->userDoingMoveUseCase = $userDoingMoveUseCase;
    }

    protected function configure()
    {
        $this
            ->setDescription('Make a Movement in a Game.')

            ->setHelp('This command allows you to make a Movement in a Game')

            ->addArgument('user1', InputArgument::REQUIRED,'First user')

            ->addArgument('user2', InputArgument::REQUIRED,'Second user')

            ->addArgument('user doing move', InputArgument::REQUIRED,'User doing Movement')

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
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $game = $this->startNewGameUseCase->__invoke(
            new User($input->getArgument('user1')),
            new User($input->getArgument('user2'))
        );

        $firstUserSelected = $game->getFirstUser()->getName() === $input->getArgument('user doing move');

        $this->userDoingMoveUseCase->__invoke(
            $game, new UserMovement(
                $firstUserSelected ? $game->getFirstUser() : $game->getSecondUser(),
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