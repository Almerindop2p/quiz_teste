@extends('layouts.app')

@section('title', 'Iniciar Quiz')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                <i class="fas fa-gamepad text-indigo-600"></i> Quiz System
            </h1>
            <p class="text-gray-600">Teste seus conhecimentos!</p>
        </div>

        <form action="{{ route('quiz.start') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-list-ol mr-1"></i> Quantidade de Questões
                </label>
                <input type="number" name="quantidade" value="10" min="1" max="50" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tags mr-1"></i> Categoria (Opcional)
                </label>
                <select name="categoria" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="">Todas as categorias</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-signal mr-1"></i> Nível (Opcional)
                </label>
                <select name="nivel" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="">Todos os níveis</option>
                    <option value="fácil">Fácil</option>
                    <option value="médio">Médio</option>
                    <option value="difícil">Difícil</option>
                </select>
            </div>

            <button type="submit" 
                    class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-indigo-700 transition duration-200 transform hover:scale-105">
                <i class="fas fa-play mr-2"></i> Iniciar Quiz
            </button>
        </form>
    </div>
</div>
@endsection
