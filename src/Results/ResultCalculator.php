<?php

declare(strict_types=1);

namespace App\Results;

use App\Quizzes\Quiz;

class ResultCalculator
{
    /**
     * @param Quiz $quiz
     * @return Result[]
     */
    public function calculateResults(Quiz $quiz): array
    {
        $results = [];

        foreach ($quiz->getQuestions() as $index => $question) {
            $userAnswer = $quiz->getUserAnswers($index);
            $correctAnswers = $question->getCorrectChoices();

            $results[] = new Result(
                $question->getInquiry(),
                $userAnswer,
                $correctAnswers,
                $this->isAnswerCorrect($userAnswer, $correctAnswers),
            );
        }

        return $results;
    }

    private function isAnswerCorrect($userAnswer, array $correctAnswers): bool
    {
        if (is_array($userAnswer)) {
            sort($userAnswer);
            sort($correctAnswers);

            return $userAnswer === $correctAnswers;
        }

        return $userAnswer === $correctAnswers[0];
    }
}
