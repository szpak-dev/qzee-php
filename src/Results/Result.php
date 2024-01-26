<?php

declare(strict_types=1);

namespace App\Results;

readonly class Result
{
    public function __construct(
        private string $question,
        private array $userAnswer,
        private array $correctAnswer,
        private bool $result,
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

    public function isCorrect(): bool
    {
        return $this->result;
    }
}
