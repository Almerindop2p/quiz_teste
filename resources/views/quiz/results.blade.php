@extends('layouts.app')

@section('title', 'Resultados do Quiz')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Score Card -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-6 text-center">
        <div class="mb-4">
            <i class="fas fa-trophy text-6xl 
                @if($score >= $total * 0.7) text-yellow-500
                @elseif($score >= $total * 0.5) text-gray-400
                @else text-orange-600
                @endif"></i>
        </div>
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Resultados</h1>
        <p class="text-2xl text-gray-600 mb-4">
            Você acertou <span class="font-bold text-indigo-600">{{ $score }}</span> de <span class="font-bold">{{ $total }}</span> questões
        </p>
        <div class="text-3xl font-bold 
            @if($score >= $total * 0.7) text-green-600
            @elseif($score >= $total * 0.5) text-yellow-600
            @else text-red-600
            @endif">
            {{ round(($score / $total) * 100) }}%
        </div>
    </div>

    <!-- Gabarito -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fas fa-clipboard-list mr-2"></i> Gabarito
        </h2>
        
        <div class="space-y-6">
            @foreach($results as $index => $result)
                <div class="border-l-4 
                    @if($result['correct']) border-green-500 bg-green-50
                    @else border-red-500 bg-red-50
                    @endif p-4 rounded">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="text-lg font-semibold text-gray-800">
                            Questão {{ $index + 1 }}
                        </h3>
                        @if($result['correct'])
                            <span class="px-3 py-1 bg-green-500 text-white rounded-full text-sm font-semibold">
                                <i class="fas fa-check mr-1"></i> Correta
                            </span>
                        @else
                            <span class="px-3 py-1 bg-red-500 text-white rounded-full text-sm font-semibold">
                                <i class="fas fa-times mr-1"></i> Incorreta
                            </span>
                        @endif
                    </div>
                    
                    <p class="text-gray-700 mb-3 font-medium">{{ $result['question']['pergunta'] }}</p>
                    
                    <div class="space-y-2">
                        @foreach(['a', 'b', 'c', 'd'] as $key)
                            <div class="flex items-center p-2 rounded
                                @if($key === $result['question']['correta']) bg-green-100 border-2 border-green-300
                                @elseif($key === $result['user_answer']) bg-red-100 border-2 border-red-300
                                @else bg-gray-50
                                @endif">
                                <span class="font-bold mr-2 
                                    @if($key === $result['question']['correta']) text-green-700
                                    @elseif($key === $result['user_answer']) text-red-700
                                    @else text-gray-500
                                    @endif">
                                    {{ strtoupper($key) }})
                                </span>
                                <span class="flex-1">{{ $result['question']['alternativas'][$key] }}</span>
                                @if($key === $result['question']['correta'])
                                    <i class="fas fa-check-circle text-green-600 ml-2"></i>
                                @endif
                                @if($key === $result['user_answer'] && !$result['correct'])
                                    <i class="fas fa-times-circle text-red-600 ml-2"></i>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-3 text-sm text-gray-600">
                        <span class="font-semibold">Sua resposta:</span> 
                        <span class="uppercase font-bold">{{ $result['user_answer'] ?? 'Não respondida' }}</span>
                        @if(!$result['correct'])
                            <span class="ml-2">
                                | <span class="font-semibold">Resposta correta:</span> 
                                <span class="uppercase font-bold text-green-700">{{ $result['question']['correta'] }}</span>
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Actions -->
    <div class="text-center space-x-4">
        <a href="{{ route('quiz.index') }}" 
           class="inline-block bg-indigo-600 text-white py-3 px-8 rounded-lg font-semibold hover:bg-indigo-700 transition duration-200 transform hover:scale-105">
            <i class="fas fa-redo mr-2"></i> Refazer Quiz
        </a>
        <a href="{{ route('questions.index') }}" 
           class="inline-block bg-gray-600 text-white py-3 px-8 rounded-lg font-semibold hover:bg-gray-700 transition duration-200 transform hover:scale-105">
            <i class="fas fa-list mr-2"></i> Ver Questões
        </a>
    </div>
</div>
@endsection
