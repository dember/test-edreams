<?php

namespace TicTacToe\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\Application\DeleteUsersUseCase;
use TicTacToe\Domain\User;

class DeleteUsersCommand extends Command
{
    protected static $defaultName = 'tictactoe:create-users';

    private $deleteUsersUseCase;

    public function __construct(DeleteUsersUseCase $deleteUsersUseCase)
    {
        parent::__construct();

        $this->deleteUsersUseCase = $deleteUsersUseCase;
    }

    protected function configure()
    {
        $this
            ->setDescription('Deletes a User.')

            ->setHelp('This command allows you to delete a User')

            ->addArgument('id', InputArgument::REQUIRED ,'User identifier')
            ->addArgument('name', InputArgument::REQUIRED ,'User name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = new User(
            $input->getArgument('id'),
            $input->getArgument('name')
        );

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