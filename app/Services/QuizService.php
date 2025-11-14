<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class QuizService
{
    private $filePath = 'quiz.json';

    /**
     * Obter todas as questões
     */
    public function getAllQuestions()
    {
        if (!Storage::exists($this->filePath)) {
            Storage::put($this->filePath, json_encode([]));
            return [];
        }

        $content = Storage::get($this->filePath);
        return json_decode($content, true) ?? [];
    }

    /**
     * Salvar questões no arquivo
     */
    public function saveQuestions(array $questions)
    {
        Storage::put($this->filePath, json_encode($questions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return true;
    }

    /**
     * Adicionar nova questão
     */
    public function addQuestion(array $data)
    {
        $questions = $this->getAllQuestions();
        
        $newQuestion = [
            'id' => $this->getNextId($questions),
            'pergunta' => $data['pergunta'],
            'alternativas' => [
                'a' => $data['alternativa_a'],
                'b' => $data['alternativa_b'],
                'c' => $data['alternativa_c'],
                'd' => $data['alternativa_d']
            ],
            'correta' => strtolower($data['correta']),
            'categoria' => $data['categoria'],
            'nivel' => $data['nivel']
        ];

        $questions[] = $newQuestion;
        $this->saveQuestions($questions);

        return $newQuestion;
    }

    /**
     * Obter questão por ID
     */
    public function getQuestionById($id)
    {
        $questions = $this->getAllQuestions();
        
        foreach ($questions as $question) {
            if ($question['id'] == $id) {
                return $question;
            }
        }

        return null;
    }

    /**
     * Atualizar questão
     */
    public function updateQuestion($id, array $data)
    {
        $questions = $this->getAllQuestions();
        
        foreach ($questions as $key => $question) {
            if ($question['id'] == $id) {
                $questions[$key] = [
                    'id' => $id,
                    'pergunta' => $data['pergunta'],
                    'alternativas' => [
                        'a' => $data['alternativa_a'],
                        'b' => $data['alternativa_b'],
                        'c' => $data['alternativa_c'],
                        'd' => $data['alternativa_d']
                    ],
                    'correta' => strtolower($data['correta']),
                    'categoria' => $data['categoria'],
                    'nivel' => $data['nivel']
                ];
                $this->saveQuestions($questions);
                return $questions[$key];
            }
        }

        return null;
    }

    /**
     * Deletar questão
     */
    public function deleteQuestion($id)
    {
        $questions = $this->getAllQuestions();
        $questions = array_filter($questions, function($question) use ($id) {
            return $question['id'] != $id;
        });

        $this->saveQuestions(array_values($questions));
        return true;
    }

    /**
     * Filtrar questões
     */
    public function filterQuestions($categoria = null, $nivel = null, $search = null)
    {
        $questions = $this->getAllQuestions();

        return array_filter($questions, function($question) use ($categoria, $nivel, $search) {
            $matchCategoria = !$categoria || strtolower($question['categoria']) === strtolower($categoria);
            $matchNivel = !$nivel || strtolower($question['nivel']) === strtolower($nivel);
            $matchSearch = !$search || 
                stripos($question['pergunta'], $search) !== false ||
                stripos($question['categoria'], $search) !== false;

            return $matchCategoria && $matchNivel && $matchSearch;
        });
    }

    /**
     * Obter categorias únicas
     */
    public function getCategories()
    {
        $questions = $this->getAllQuestions();
        $categories = array_unique(array_column($questions, 'categoria'));
        sort($categories);
        return $categories;
    }

    /**
     * Obter próximo ID
     */
    private function getNextId(array $questions)
    {
        if (empty($questions)) {
            return 1;
        }

        $ids = array_column($questions, 'id');
        return max($ids) + 1;
    }

    /**
     * Obter questões aleatórias para o quiz
     */
    public function getRandomQuestions($limit = 10, $categoria = null, $nivel = null)
    {
        $questions = $this->getAllQuestions();

        if ($categoria || $nivel) {
            $questions = $this->filterQuestions($categoria, $nivel);
        }

        shuffle($questions);
        return array_slice($questions, 0, min($limit, count($questions)));
    }
}
