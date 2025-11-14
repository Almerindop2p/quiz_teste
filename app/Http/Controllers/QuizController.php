<?php

namespace App\Http\Controllers;

use App\Services\QuizService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    /**
     * Exibir tela inicial do quiz
     */
    public function index()
    {
        $categories = $this->quizService->getCategories();
        return view('quiz.index', compact('categories'));
    }

    /**
     * Iniciar quiz
     */
    public function start(Request $request)
    {
        $validated = $request->validate([
            'quantidade' => 'nullable|integer|min:1|max:50',
            'categoria' => 'nullable|string',
            'nivel' => 'nullable|in:fácil,médio,difícil'
        ]);

        $quantidade = $validated['quantidade'] ?? 10;
        $categoria = $validated['categoria'] ?? null;
        $nivel = $validated['nivel'] ?? null;

        $questions = $this->quizService->getRandomQuestions($quantidade, $categoria, $nivel);

        if (empty($questions)) {
            return redirect()->route('quiz.index')
                ->with('error', 'Nenhuma questão encontrada com os filtros selecionados!');
        }

        // Salvar questões na sessão
        session(['quiz_questions' => $questions, 'quiz_answers' => [], 'quiz_current' => 0]);

        return redirect()->route('quiz.play');
    }

    /**
     * Jogar quiz - exibir pergunta atual
     */
    public function play()
    {
        $questions = session('quiz_questions', []);
        $current = session('quiz_current', 0);
        $answers = session('quiz_answers', []);

        if (empty($questions) || $current >= count($questions)) {
            return redirect()->route('quiz.results');
        }

        $question = $questions[$current];
        $progress = (($current + 1) / count($questions)) * 100;

        return view('quiz.play', compact('question', 'current', 'questions', 'progress'));
    }

    /**
     * Processar resposta
     */
    public function answer(Request $request)
    {
        $validated = $request->validate([
            'resposta' => 'required|in:a,b,c,d'
        ]);

        $questions = session('quiz_questions', []);
        $current = session('quiz_current', 0);
        $answers = session('quiz_answers', []);

        if ($current < count($questions)) {
            $question = $questions[$current];
            $answers[$current] = [
                'question_id' => $question['id'],
                'resposta' => $validated['resposta'],
                'correta' => $question['correta']
            ];

            session(['quiz_answers' => $answers, 'quiz_current' => $current + 1]);
        }

        if ($current + 1 >= count($questions)) {
            return redirect()->route('quiz.results');
        }

        return redirect()->route('quiz.play');
    }

    /**
     * Exibir resultados
     */
    public function results()
    {
        $questions = session('quiz_questions', []);
        $answers = session('quiz_answers', []);

        if (empty($questions)) {
            return redirect()->route('quiz.index');
        }

        $score = 0;
        $total = count($questions);

        foreach ($answers as $answer) {
            if (strtolower($answer['resposta']) === strtolower($answer['correta'])) {
                $score++;
            }
        }

        // Combinar questões com respostas para exibir gabarito
        $results = [];
        foreach ($questions as $index => $question) {
            $userAnswer = isset($answers[$index]) ? $answers[$index]['resposta'] : null;
            $results[] = [
                'question' => $question,
                'user_answer' => $userAnswer,
                'correct' => $userAnswer && strtolower($userAnswer) === strtolower($question['correta'])
            ];
        }

        // Limpar sessão
        session()->forget(['quiz_questions', 'quiz_answers', 'quiz_current']);

        return view('quiz.results', compact('score', 'total', 'results'));
    }
}
