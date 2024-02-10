<?php

declare(strict_types=1);

namespace App\Quizzes;

use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class QuizRunner
{
    public function runQuiz(Quiz $quiz, InputInterface $input, OutputInterface $output): void
    {
        $helper = $this->getQuestionHelper();

        foreach ($quiz->getQuestions() as $index => $question) {
            $questionText = $question->getInquiry();
            $isMulti = $question->isMultiChoice();
            $choices = $question->getAllChoices();

            $question = $this->createQuestion($index, $questionText, $choices, $isMulti);
            $answer = $helper->ask($input, $output, $question);

            if (is_string($answer)) {
                $answer = [$answer];
            }

            $quiz->recordUserAnswer($index, $answer);
        }
    }

    private function getQuestionHelper(): QuestionHelper
    {
        return new QuestionHelper();
    }

    private function createQuestion(int $index, string $questionText, array $choices, bool $isMulti): ChoiceQuestion
    {
        $text = '<info>Question ' . ($index + 1) . ': </info>' . $questionText;
        $question = new ChoiceQuestion($text, $this->removeCorrectIndicator($choices));

        if ($isMulti) {
            $question->setMultiselect(true);
        }

        return $question;
    }

    private function removeCorrectIndicator(array $choices): array
    {
        return array_map(
            static fn($choice) => str_replace('@', '', $choice),
            $choices,
        );
    }
}
