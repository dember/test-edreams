<?php

namespace TicTacToe\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\Application\CheckForGameFinishedWinnerUseCase;
use TicTacToe\Domain\GameRepository;

class CheckForGameFinishedWinnerCommand extends Command
{
    protected static $defaultName = 'tictactoe:game-check';

    private $gameRepository;
    private $checkForGameFinishedWinnerUseCase;

    public function __construct(GameRepository $gameRepository, CheckForGameFinishedWinnerUseCase $checkForGameFinishedWinnerUseCase)
    {
        parent::__construct();

        $this->gameRepository = $gameRepository;
        $this->checkForGameFinishedWinnerUseCase = $checkForGameFinishedWinnerUseCase;
    }

    protected function configure()
    {
        $this
            ->setDescription('Check info for a Game')

            ->setHelp('This command allows you to check if a Game is finished and if there is a winner')

            ->addArgument('game_id', InputArgument::REQUIRED,'Game identifier');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $game = $this->gameRepository->find($input->getArgument('game_id'));

        if (is_null($game)) {
            $output->writeln([
                'Game not found',
                '=========================',
                '',
            ]);
        } else {
            $information = $this->checkForGameFinishedWinnerUseCase->__invoke(
                $game
            );

            $output->writeln([
                'Game status',
                '=========================',
                'Has finished? - ' . ($information['hasFinished'] ? 'Yes' : 'No'),
                'Winner - ' . ($information['winner'] ?? 'Undefined'),
            ]);
        }
    }
}