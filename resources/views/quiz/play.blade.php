@extends('layouts.app')

@section('title', 'Jogando Quiz')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Progress Bar -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-gray-700">
                Questão {{ $current + 1 }} de {{ count($questions) }}
            </span>
            <span class="text-sm font-medium text-gray-700">{{ round($progress) }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-indigo-600 h-3 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
        </div>
    </div>

    <!-- Question Card -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-6 animate-fade-in">
        <div class="mb-6">
            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full 
                @if($question['nivel'] === 'fácil') bg-green-100 text-green-800
                @elseif($question['nivel'] === 'médio') bg-yellow-100 text-yellow-800
                @else bg-red-100 text-red-800
                @endif">
                {{ ucfirst($question['nivel']) }}
            </span>
            <span class="inline-block ml-2 px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                {{ $question['categoria'] }}
            </span>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $question['pergunta'] }}</h2>

        <form action="{{ route('quiz.answer') }}" method="POST" class="space-y-4">
            @csrf
            <div class="space-y-3">
                @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $key => $label)
                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition duration-200">
                        <input type="radio" name="resposta" value="{{ $key }}" required 
                               class="w-5 h-5 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-4 text-lg font-medium text-gray-700">
                            <span class="font-bold text-indigo-600 mr-2">{{ $label }})</span>
                            {{ $question['alternativas'][$key] }}
                        </span>
                    </label>
                @endforeach
            </div>

            <button type="submit" 
                    class="w-full mt-6 bg-indigo-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-indigo-700 transition duration-200 transform hover:scale-105">
                <i class="fas fa-arrow-right mr-2"></i> 
                {{ $current + 1 < count($questions) ? 'Próxima Questão' : 'Finalizar Quiz' }}
            </button>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-in-out;
    }
</style>
@endsection
