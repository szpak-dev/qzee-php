<?php

declare(strict_types=1);

namespace App\Quizzes;

use Symfony\Component\Console\Style\SymfonyStyle;

readonly class QuizLister
{
    /**
     * @param Quiz[] $quizzes
     * @param SymfonyStyle $io
     * @return void
     */
    public function listQuizzes(array $quizzes, SymfonyStyle $io): void
    {
        $io->title('Available Quizzes');
        $io->text('Select a quiz by typing its name:');
        $io->newLine();

        if (empty($quizzes)) {
            $io->warning('No quizzes found.');
        } else {
            $io->table(
                ['Load by', 'Name', 'Level', 'Categories'],
                $this->formatQuizzesTable($quizzes)
            );
        }
    }

    /**
     * @param Quiz[] $quizzes
     * @return array
     */
    private function formatQuizzesTable(array $quizzes): array
    {
        $formattedQuizzes = [];

        foreach ($quizzes as $quiz) {
            $formattedQuizzes[] = [
                $quiz->getSlug(),
                '<info>' . $this->formatQuizName($quiz->getTitle()) . '</info>',
                $quiz->getLevel(),
                implode(', ', $quiz->getCategories()),
            ];
        }

        return $formattedQuizzes;
    }

    private function formatQuizName(string $quizName): string
    {
        return '<options=bold>' . $quizName . '</>';
    }
}
