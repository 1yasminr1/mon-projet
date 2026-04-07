@extends('layouts.apprenant')
@section('title', 'Quiz')
@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">📝 {{ $evaluation->titre }}</h1>
    <p class="text-gray-500 mt-1">
        {{ $questions->count() }} questions — Note minimale : {{ $evaluation->note_min }}/20
    </p>
</div>

<div class="max-w-2xl mx-auto">
    <form method="POST" action="{{ route('apprenant.quiz.soumettre', $evaluation->id) }}">
        @csrf

        @foreach($questions as $i => $question)
        <div class="bg-white rounded-xl shadow p-6 mb-4">
            <p class="font-bold text-gray-800 mb-4">
                {{ $i + 1 }}. {{ $question->question }}
            </p>
            <div class="space-y-2">
                @foreach(['a' => $question->reponse_a, 'b' => $question->reponse_b, 'c' => $question->reponse_c, 'd' => $question->reponse_d] as $key => $reponse)
                <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-400 transition">
                    <input type="radio" name="reponses[{{ $question->id }}]" value="{{ $key }}" required
                           class="w-4 h-4 text-blue-600">
                    <span class="font-medium text-sm">{{ strtoupper($key) }})</span>
                    <span class="text-sm">{{ $reponse }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
            <p class="text-yellow-700 text-sm">
                ⚠️ Une fois soumis, vous ne pouvez plus modifier vos réponses.
            </p>
        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-blue-700">
            Soumettre mes réponses →
        </button>
    </form>
</div>

@endsection