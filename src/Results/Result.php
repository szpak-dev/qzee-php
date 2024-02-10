<?php

declare(strict_types=1);

namespace App\Results;

readonly class Result
{
    public function __construct(
        private string $question,
        private array $userAnswer,
        private array $correctAnswer,
    ) {
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getUserAnswer(): array
    {
        return $this->userAnswer;
    }

    public function getCorrectAnswer(): array
    {
        return $this->correctAnswer;
    }

    public function isAnswerCorrect(): bool
    {
        $userAnswer = $this->getUserAnswer();
        $correctAnswer = $this->getCorrectAnswer();

        if (is_array($this->userAnswer)) {
            sort($userAnswer);
            sort($correctAnswer);

            return $this->userAnswer === $this->correctAnswer;
        }

        return $this->userAnswer === $this->correctAnswer[0];
    }
}
