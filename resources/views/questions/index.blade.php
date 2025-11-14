@extends('layouts.app')

@section('title', 'Gerenciar Questões')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-list mr-2"></i> Gerenciar Questões
        </h1>
        <a href="{{ route('questions.create') }}" 
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
            <i class="fas fa-plus mr-2"></i> Nova Questão
        </a>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('questions.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search mr-1"></i> Buscar
                </label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Palavra-chave..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tags mr-1"></i> Categoria
                </label>
                <select name="categoria" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">Todas</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ $categoria === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-signal mr-1"></i> Nível
                </label>
                <select name="nivel" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">Todos</option>
                    <option value="fácil" {{ $nivel === 'fácil' ? 'selected' : '' }}>Fácil</option>
                    <option value="médio" {{ $nivel === 'médio' ? 'selected' : '' }}>Médio</option>
                    <option value="difícil" {{ $nivel === 'difícil' ? 'selected' : '' }}>Difícil</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" 
                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200">
                    <i class="fas fa-filter mr-2"></i> Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Questões -->
    <div class="space-y-4">
        @forelse($questions as $question)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                @if($question['nivel'] === 'fácil') bg-green-100 text-green-800
                                @elseif($question['nivel'] === 'médio') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($question['nivel']) }}
                            </span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                {{ $question['categoria'] }}
                            </span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">{{ $question['pergunta'] }}</h3>
                        <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                            @foreach($question['alternativas'] as $key => $alt)
                                <div>
                                    <span class="font-bold text-indigo-600">{{ strtoupper($key) }})</span> {{ $alt }}
                                    @if($key === $question['correta'])
                                        <i class="fas fa-check-circle text-green-600 ml-1"></i>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex space-x-2 ml-4">
                        <a href="{{ route('questions.edit', $question['id']) }}" 
                           class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('questions.destroy', $question['id']) }}" method="POST" 
                              onsubmit="return confirm('Tem certeza que deseja deletar esta questão?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-inbox text-6xl text-gray-400 mb-4"></i>
                <p class="text-xl text-gray-600">Nenhuma questão encontrada</p>
                <a href="{{ route('questions.create') }}" 
                   class="inline-block mt-4 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-200">
                    <i class="fas fa-plus mr-2"></i> Criar Primeira Questão
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
