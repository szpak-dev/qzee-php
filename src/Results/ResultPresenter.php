<?php

declare(strict_types=1);

namespace App\Results;

use Symfony\Component\Console\Output\OutputInterface;

class ResultPresenter
{
    /**
     * @param Result[] $results
     * @param OutputInterface $output
     * @return void
     */
    public function displayResults(array $results, OutputInterface $output): void
    {
        $output->writeln('');
        $output->writeln('<info>Quiz Completed. Results:</info>');
        $output->writeln('<info>========================</info>');
        $output->writeln('');

        foreach ($results as $index => $result) {
            $output->writeln(sprintf('<fg=yellow>Question %d:</> %s', ($index + 1), $result->getQuestion()));

            if ($result->isAnswerCorrect()) {
                $output->writeln(sprintf(
                    "Your Answer: <fg=green>%s</>\n",
                    $this->formatAnswer($result->getUserAnswer()),
                ));

                continue;
            }

            $output->writeln(sprintf(
                "Your Answer: <fg=red>%s</> | Correct Answer: %s\n",
                $this->formatAnswer($result->getUserAnswer()),
                $this->formatAnswer($result->getCorrectAnswer()),
            ));
        }
    }

    private function formatAnswer($answer): string
    {
        if (is_array($answer)) {
            return implode(', ', array_map(static fn($choice) => (string) $choice, $answer));
        }

        return (string) $answer;
    }
}
