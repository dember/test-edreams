<?php

namespace TicTacToe\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\Application\DeleteUsersUseCase;
use TicTacToe\Infrastructure\UserRepositoryInMemory;

class DeleteUsersCommand extends Command
{
    protected static $defaultName = 'tictactoe:delete-users';

    private $userRepositoryInMemory;
    private $deleteUsersUseCase;

    public function __construct(DeleteUsersUseCase $deleteUsersUseCase, UserRepositoryInMemory $userRepositoryInMemory)
    {
        parent::__construct();

        $this->userRepositoryInMemory = $userRepositoryInMemory;
        $this->deleteUsersUseCase     = $deleteUsersUseCase;
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
        $user = $this->userRepositoryInMemory->find($input->getArgument('user_id'));

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