<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

// Rotas do Quiz (Jogador)
Route::get('/', [QuizController::class, 'index'])->name('quiz.index');
Route::post('/quiz/start', [QuizController::class, 'start'])->name('quiz.start');
Route::get('/quiz/play', [QuizController::class, 'play'])->name('quiz.play');
Route::post('/quiz/answer', [QuizController::class, 'answer'])->name('quiz.answer');
Route::get('/quiz/results', [QuizController::class, 'results'])->name('quiz.results');

// Rotas de Gerenciamento de Questões
Route::prefix('questions')->name('questions.')->group(function () {
    Route::get('/', [QuestionController::class, 'index'])->name('index');
    Route::get('/create', [QuestionController::class, 'create'])->name('create');
    Route::post('/', [QuestionController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [QuestionController::class, 'edit'])->name('edit');
    Route::put('/{id}', [QuestionController::class, 'update'])->name('update');
    Route::delete('/{id}', [QuestionController::class, 'destroy'])->name('destroy');
});
