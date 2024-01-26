<?php

declare(strict_types=1);

namespace App\Quizzes;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class QuizLoader
{
    private string $quizFilesDirectory;
    private const extensions = ['*.yaml', '*.yml'];

    public function __construct(string $quizFilesDirectory)
    {
        $this->quizFilesDirectory = $quizFilesDirectory;
    }

    /**
     * Lists available quizzes.
     *
     * @return array<Quiz>
     */
    public function loadAll(): array
    {
        $finder = new Finder();
        $finder->files()->name(self::extensions)->in($this->quizFilesDirectory);

        $quizzes = [];
        foreach ($finder as $file) {
            $quizzes[] = $this->loadQuiz($file->getFilename());
        }

        return $quizzes;
    }

    public function loadQuiz(string $filename): Quiz
    {
        $slug = explode('.', $filename)[0];
        $filePath = $this->quizFilesDirectory . '/' . $filename;

        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("Quiz file '$slug' not found.");
        }

        $quizData = Yaml::parseFile($filePath);

        if (!is_array($quizData) || !isset($quizData['questions'])) {
            throw new \InvalidArgumentException("Invalid quiz file: $filePath");
        }

        return new Quiz($slug, $quizData);
    }
}