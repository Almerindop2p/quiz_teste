<?php

namespace App\Http\Controllers;

use App\Services\QuizService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    /**
     * Exibir formulário de cadastro
     */
    public function create()
    {
        $categories = $this->quizService->getCategories();
        return view('questions.create', compact('categories'));
    }

    /**
     * Salvar nova questão
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pergunta' => 'required|string|min:10',
            'alternativa_a' => 'required|string',
            'alternativa_b' => 'required|string',
            'alternativa_c' => 'required|string',
            'alternativa_d' => 'required|string',
            'correta' => 'required|in:a,b,c,d,A,B,C,D',
            'categoria' => 'required|string',
            'nivel' => 'required|in:fácil,médio,difícil'
        ]);

        $question = $this->quizService->addQuestion($validated);

        return redirect()->route('questions.index')
            ->with('success', 'Questão cadastrada com sucesso!');
    }

    /**
     * Listar questões com filtros
     */
    public function index(Request $request)
    {
        $categoria = $request->get('categoria');
        $nivel = $request->get('nivel');
        $search = $request->get('search');

        $questions = $this->quizService->filterQuestions($categoria, $nivel, $search);
        $categories = $this->quizService->getCategories();

        return view('questions.index', compact('questions', 'categories', 'categoria', 'nivel', 'search'));
    }

    /**
     * Exibir formulário de edição
     */
    public function edit($id)
    {
        $question = $this->quizService->getQuestionById($id);
        
        if (!$question) {
            return redirect()->route('questions.index')
                ->with('error', 'Questão não encontrada!');
        }

        $categories = $this->quizService->getCategories();
        return view('questions.edit', compact('question', 'categories'));
    }

    /**
     * Atualizar questão
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pergunta' => 'required|string|min:10',
            'alternativa_a' => 'required|string',
            'alternativa_b' => 'required|string',
            'alternativa_c' => 'required|string',
            'alternativa_d' => 'required|string',
            'correta' => 'required|in:a,b,c,d,A,B,C,D',
            'categoria' => 'required|string',
            'nivel' => 'required|in:fácil,médio,difícil'
        ]);

        $question = $this->quizService->updateQuestion($id, $validated);

        if (!$question) {
            return redirect()->route('questions.index')
                ->with('error', 'Questão não encontrada!');
        }

        return redirect()->route('questions.index')
            ->with('success', 'Questão atualizada com sucesso!');
    }

    /**
     * Deletar questão
     */
    public function destroy($id)
    {
        $this->quizService->deleteQuestion($id);
        return redirect()->route('questions.index')
            ->with('success', 'Questão deletada com sucesso!');
    }
}
