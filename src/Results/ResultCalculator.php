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
            $results[] = new Result(
                $question->getInquiry(),
                $quiz->getUserAnswers($index),
                $question->getCorrectChoices(),
            );
        }

        return $results;
    }


}
