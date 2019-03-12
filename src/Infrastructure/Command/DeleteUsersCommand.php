<?php

namespace TicTacToe\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\Application\DeleteUsersUseCase;
use TicTacToe\Domain\UserRepository;

class DeleteUsersCommand extends Command
{
    protected static $defaultName = 'tictactoe:delete-users';

    private $userRepository;
    private $deleteUsersUseCase;

    public function __construct(DeleteUsersUseCase $deleteUsersUseCase, UserRepository $userRepository)
    {
        parent::__construct();

        $this->userRepository     = $userRepository;
        $this->deleteUsersUseCase = $deleteUsersUseCase;
    }

    protected function configure()
    {
        $this
            ->setDescription('Deletes a User.')
            ->setHelp('This command allows you to delete a User')
            ->addArgument('user_id', InputArgument::REQUIRED, 'User identifier');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userRepository->find($input->getArgument('user_id'));

        if (is_null($user)) {
            $output->writeln([
                'User not found',
                '=========================',
                '',
            ]);
        } else {
            $this->deleteUsersUseCase->__invoke(
                $user
            );

            $output->writeln([
                'User successfully deleted',
                '=========================',
                '',
            ]);
        }
    }
}