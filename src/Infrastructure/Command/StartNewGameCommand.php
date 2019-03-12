<?php

namespace TicTacToe\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\Application\StartNewGameUseCase;
use TicTacToe\Domain\Exception\NonUniqueUsersAtGameCreationException;
use TicTacToe\Domain\User;

class StartNewGameCommand extends Command
{
    protected static $defaultName = 'tictactoe:new-game';

    private $startNewGameUseCase;

    public function __construct(StartNewGameUseCase $startNewGameUseCase)
    {
        parent::__construct();

        $this->startNewGameUseCase = $startNewGameUseCase;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new Tictactoe game.')

            ->setHelp('This command allows you to create a new TicTacToe game')

            ->addArgument('user1_id', InputArgument::REQUIRED ,'First user identifier')
            ->addArgument('user1', InputArgument::REQUIRED ,'First user')

            ->addArgument('user2_id', InputArgument::REQUIRED ,'Second user identifier')
            ->addArgument('user2', InputArgument::REQUIRED ,'Second user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $game = null;

        try {
            $game = $this->startNewGameUseCase->__invoke(
                new User(
                    $input->getArgument('user1_id'),
                    $input->getArgument('user1')
                ),
                new User(
                    $input->getArgument('user2_id'),
                    $input->getArgument('user2')
                )
            );

            $output->writeln([
                'Game successfully started',
                '=========================',
                '',
            ]);
        } catch (NonUniqueUsersAtGameCreationException $exception) {
            $output->writeln([
                'An exception was found: ' . $exception->getMessage(),
                '=========================',
                '',
            ]);
        }

        return $game;
    }
}