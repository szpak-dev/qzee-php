<?php

declare(strict_types=1);

namespace App\Quizzes;

class Quiz
{
    private string $slug;
    private array $data;
    private array $questions = [];
    private array $userAnswers = [];

    public function __construct(string $slug, array $data)
    {
        $this->slug = $slug;
        $this->data = $data;

        foreach ($data['questions'] as $questionData) {
            $this->questions[] = new Question($questionData);
        }
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getTitle(): string
    {
        return $this->data['title'];
    }

    public function getLevel(): string
    {
        return $this->data['level'];
    }

    /**
     * @return string[]
     */
    public function getCategories(): array
    {
        return $this->data['categories'];
    }

    /**
     * @return Question[]
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function recordUserAnswer(int $questionIndex, array $userAnswer): void
    {
        if ($questionIndex < 0 || $questionIndex >= count($this->questions)) {
            throw new \InvalidArgumentException('Invalid question index.');
        }

        $this->userAnswers[$questionIndex] = $userAnswer;
    }

    public function getUserAnswers(int $index): array
    {
        return $this->userAnswers[$index];
    }
}
