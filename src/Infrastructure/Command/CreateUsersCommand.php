<?php

namespace TicTacToe\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\Application\CreateUsersUseCase;

class CreateUsersCommand extends Command
{
    protected static $defaultName = 'tictactoe:create-users';

    private $createUsersUseCase;

    public function __construct(CreateUsersUseCase $createUsersUseCase)
    {
        parent::__construct();

        $this->createUsersUseCase = $createUsersUseCase;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new User.')

            ->setHelp('This command allows you to create a new User')

            ->addArgument('id', InputArgument::REQUIRED ,'User identifier')
            ->addArgument('name', InputArgument::REQUIRED ,'User name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->createUsersUseCase->__invoke(
            $input->getArgument('id'),
            $input->getArgument('name')
        );

        $output->writeln([
            'User successfully created',
            '=========================',
            '',
        ]);

        return $user;
    }
}