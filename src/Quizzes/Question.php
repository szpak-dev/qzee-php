<?php

declare(strict_types=1);

namespace App\Quizzes;

class Question
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getInquiry(): string
    {
        return $this->data['inquiry'];
    }

    public function isMultiChoice(): bool
    {
        return $this->data['multi'];
    }

    public function getAllChoices(): array
    {
        return $this->data['answers'];
    }

    public function getCorrectChoices(): array
    {
        $markedAnswers =  array_filter(
            $this->getAllChoices(),
            static fn($choice) => str_starts_with($choice, '@'),
        );

        return array_values(array_map(
            static fn(string $answer) => substr($answer, 1),
            $markedAnswers,
        ));
    }
}
