<?php

declare(strict_types=1);

namespace App;

use App\Commands\ListQuizzesCommand;
use App\Commands\RunQuizCommand;
use App\Quizzes\QuizLister;
use App\Quizzes\QuizLoader;
use App\Quizzes\QuizRunner;
use App\Results\ResultCalculator;
use App\Results\ResultPresenter;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class QuizApplication extends Application
{
    public function __construct(
        private readonly QuizLoader $quizLoader,
        private readonly QuizLister $quizLister,
        private readonly ResultCalculator $resultCalculator,
        private readonly ResultPresenter $resultPresenter,
        private readonly QuizRunner $quizRunner,
    ) {
        parent::__construct();

        $this->addCommands([
            new ListQuizzesCommand($this),
            new RunQuizCommand($this),
        ]);
    }

    public function startQuiz(string $filename, InputInterface $input, OutputInterface $output): void
    {
        try {
            $quiz = $this->quizLoader->loadQuiz($filename);

            $output->writeln('<info>Selected Quiz:</info>');
            $output->writeln('Title: ' . $quiz->getTitle());
            $output->writeln('Level: ' . $quiz->getLevel());
            $output->writeln('Categories: ' . implode(', ', $quiz->getCategories()));
            $output->writeln('');

            $this->quizRunner->runQuiz($quiz, $input, $output);
            $results = $this->resultCalculator->calculateResults($quiz);

            $this->resultPresenter->displayResults($results, $output);
        } catch (\Exception $e) {
            $output->writeln('<fg=red>' . $e->getMessage() . '</>');
        }
    }

    public function listAll(InputInterface $input, OutputInterface $output): void
    {
        $quizzes = $this->quizLoader->loadAll();
        $this->quizLister->listQuizzes($quizzes, new SymfonyStyle($input, $output));
    }
}
