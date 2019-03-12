<?php

namespace TicTacToe\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\Application\UserDoingMoveUseCase;
use TicTacToe\Domain\GameRepository;
use TicTacToe\Domain\Position;
use TicTacToe\Domain\UserMovement;
use TicTacToe\Domain\UserRepository;

class UserDoingMoveCommand extends Command
{
    protected static $defaultName = 'tictactoe:game-move';

    private $gameRepository;
    private $userRepository;
    private $userDoingMoveUseCase;

    public function __construct(
        GameRepository $gameRepository,
        UserRepository $userRepository,
        UserDoingMoveUseCase $userDoingMoveUseCase
    )
    {
        parent::__construct();

        $this->gameRepository = $gameRepository;

        $this->userRepository = $userRepository;

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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $game = $this->gameRepository->find($input->getArgument('game_id'));
        $user = $this->userRepository->find($input->getArgument('user_id'));

        if (is_null($game) || is_null($user)) {
            $output->writeln([
                'Game or User Not Found',
                '=========================',
                '',
            ]);
        } else {
            try {
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
            } catch (\Exception $exception) {
                $output->writeln([
                    'An exception was found: ' . $exception->getMessage(),
                    '=========================',
                    '',
                ]);
            }
        }
    }
}