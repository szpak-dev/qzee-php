<?php

declare(strict_types=1);

namespace App\Commands;

use App\QuizApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunQuizCommand extends Command
{
    public function __construct(
        private readonly QuizApplication $quizApp,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('quiz:run')
            ->setDescription('Run a quiz')
            ->addArgument('quiz_name', InputArgument::REQUIRED, 'Name of the quiz file (without extension)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('quiz_name') . '.yml';
        $this->quizApp->startQuiz($filename, $input, $output);
        return Command::SUCCESS;
    }
}
