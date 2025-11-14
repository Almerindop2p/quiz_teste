@extends('layouts.app')

@section('title', 'Editar Questão')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            <i class="fas fa-edit mr-2"></i> Editar Questão
        </h1>

        <form action="{{ route('questions.update', $question['id']) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Pergunta <span class="text-red-500">*</span>
                </label>
                <textarea name="pergunta" rows="3" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ $question['pergunta'] }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Alternativa A <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="alternativa_a" value="{{ $question['alternativas']['a'] }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Alternativa B <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="alternativa_b" value="{{ $question['alternativas']['b'] }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Alternativa C <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="alternativa_c" value="{{ $question['alternativas']['c'] }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Alternativa D <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="alternativa_d" value="{{ $question['alternativas']['d'] }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Resposta Correta <span class="text-red-500">*</span>
                </label>
                <select name="correta" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="a" {{ $question['correta'] === 'a' ? 'selected' : '' }}>A</option>
                    <option value="b" {{ $question['correta'] === 'b' ? 'selected' : '' }}>B</option>
                    <option value="c" {{ $question['correta'] === 'c' ? 'selected' : '' }}>C</option>
                    <option value="d" {{ $question['correta'] === 'd' ? 'selected' : '' }}>D</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Categoria <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="categoria" value="{{ $question['categoria'] }}" list="categories" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <datalist id="categories">
                        @foreach($categories as $category)
                            <option value="{{ $category }}">
                        @endforeach
                    </datalist>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nível <span class="text-red-500">*</span>
                    </label>
                    <select name="nivel" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="fácil" {{ $question['nivel'] === 'fácil' ? 'selected' : '' }}>Fácil</option>
                        <option value="médio" {{ $question['nivel'] === 'médio' ? 'selected' : '' }}>Médio</option>
                        <option value="difícil" {{ $question['nivel'] === 'difícil' ? 'selected' : '' }}>Difícil</option>
                    </select>
                </div>
            </div>

            <div class="flex space-x-4">
                <button type="submit" 
                        class="flex-1 bg-indigo-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-indigo-700 transition duration-200">
                    <i class="fas fa-save mr-2"></i> Atualizar Questão
                </button>
                <a href="{{ route('questions.index') }}" 
                   class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition duration-200 text-center">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
