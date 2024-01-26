<?php

declare(strict_types=1);

namespace App\Commands;

use App\QuizApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListQuizzesCommand extends Command
{
    public function __construct(private readonly QuizApplication $quizApplication)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('quiz:list')
            ->setDescription('List all available quizzes');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->quizApplication->listAll($input, $output);
        return Command::SUCCESS;
    }
}
