@extends('layouts.formateur')
@section('title', 'Évaluations')
@section('content')

<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">📝 Évaluations</h1>
        <p class="text-gray-500 mt-1">Formation : <span class="font-semibold text-green-600">{{ $formation->titre }}</span></p>
    </div>
    <a href="{{ route('formateur.formations.index') }}"
       class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm">← Retour</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- CRÉER ÉVALUATION -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="font-bold text-lg mb-4">➕ Créer une évaluation</h2>
        <form method="POST" action="{{ route('formateur.formations.evaluations.store', $formation->id) }}">
            @csrf
            <input type="text" name="titre" placeholder="Titre de l'évaluation" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 mb-3 text-sm focus:outline-none focus:border-green-500">
            <select name="type" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 mb-3 text-sm focus:outline-none focus:border-green-500">
                <option value="">-- Type --</option>
                <option value="quiz">📝 Quiz</option>
                <option value="examen">📋 Examen</option>
            </select>
            <div class="flex items-center gap-2 mb-4">
                <label class="text-sm text-gray-700 font-medium">Note minimale (/20) :</label>
                <input type="number" name="note_min" value="10" min="1" max="20"
                    class="w-20 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-500">
            </div>
            <button class="bg-green-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-green-700 w-full">
                Créer
            </button>
        </form>
    </div>

    <!-- LISTE ÉVALUATIONS -->
    <div class="space-y-4">
        @forelse($evaluations as $evaluation)
        <div class="bg-white rounded-xl shadow p-5">
            <div class="flex justify-between items-center mb-3">
                <div>
                    <h3 class="font-bold">{{ $evaluation->titre }}</h3>
                    <div class="flex gap-2 mt-1">
                        <span class="bg-purple-100 text-purple-700 text-xs px-2 py-0.5 rounded-full">
                            {{ $evaluation->type }}
                        </span>
                        <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full">
                            Min: {{ $evaluation->note_min }}/20
                        </span>
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">
                            {{ $evaluation->questions->count() }} questions
                        </span>
                    </div>
                </div>
            </div>

            <!-- AJOUTER QUESTION -->
            <div class="border-t pt-3">
                <p class="text-xs font-semibold text-gray-500 mb-2">➕ Ajouter une question :</p>
                <form method="POST" action="{{ route('formateur.evaluations.questions.store', $evaluation->id) }}">
                    @csrf
                    <input type="text" name="question" placeholder="Question" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs mb-2 focus:outline-none focus:border-green-500">
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <input type="text" name="reponse_a" placeholder="A) Réponse A" required
                            class="border border-gray-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:border-green-500">
                        <input type="text" name="reponse_b" placeholder="B) Réponse B" required
                            class="border border-gray-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:border-green-500">
                        <input type="text" name="reponse_c" placeholder="C) Réponse C" required
                            class="border border-gray-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:border-green-500">
                        <input type="text" name="reponse_d" placeholder="D) Réponse D" required
                            class="border border-gray-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:border-green-500">
                    </div>
                    <select name="bonne_reponse" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs mb-2 focus:outline-none focus:border-green-500">
                        <option value="">-- Bonne réponse --</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                    </select>
                    <button class="bg-purple-500 text-white text-xs px-4 py-2 rounded-lg hover:bg-purple-600 w-full">
                        Ajouter la question
                    </button>
                </form>
            </div>

            <!-- LISTE QUESTIONS -->
            @if($evaluation->questions->count() > 0)
            <div class="border-t pt-3 mt-3">
                <p class="text-xs font-semibold text-gray-500 mb-2">Questions :</p>
                @foreach($evaluation->questions as $i => $q)
                <div class="bg-gray-50 px-3 py-2 rounded-lg mb-1 text-xs">
                    <p class="font-medium">{{ $i+1 }}. {{ $q->question }}</p>
                    <p class="text-gray-400 mt-0.5">
                        A: {{ $q->reponse_a }} | B: {{ $q->reponse_b }} |
                        C: {{ $q->reponse_c }} | D: {{ $q->reponse_d }}
                    </p>
                    <p class="text-green-600 font-semibold mt-0.5">
                        ✅ Bonne réponse: {{ strtoupper($q->bonne_reponse) }}
                    </p>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @empty
        <div class="bg-white rounded-xl shadow p-8 text-center text-gray-400">
            Aucune évaluation
        </div>
        @endforelse
    </div>
</div>

@endsection