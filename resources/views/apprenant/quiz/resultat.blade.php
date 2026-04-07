@extends('layouts.apprenant')
@section('title', 'Résultat')
@section('content')

<div class="max-w-lg mx-auto text-center">

    @if($resultat->reussi)
    <div class="bg-white rounded-2xl shadow-xl p-12">
        <div class="text-7xl mb-4">🎉</div>
        <h1 class="text-3xl font-bold text-green-600 mb-2">Félicitations !</h1>
        <p class="text-gray-500 mb-6">Vous avez réussi l'évaluation</p>
        <div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-6">
            <p class="text-5xl font-bold text-green-600">{{ $resultat->note }}/20</p>
            <p class="text-gray-500 mt-2">Note obtenue</p>
        </div>
        <p class="text-gray-600 text-sm mb-6">
            Note minimale requise : {{ $evaluation->note_min }}/20 ✅
        </p>
        <div class="flex gap-3 justify-center">
            <a href="{{ route('apprenant.certificats.index') }}"
               class="bg-yellow-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-yellow-600">
                🏆 Mes certificats
            </a>
            <a href="{{ route('apprenant.formations.index') }}"
               class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-300">
                Catalogue
            </a>
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-xl p-12">
        <div class="text-7xl mb-4">😔</div>
        <h1 class="text-3xl font-bold text-red-500 mb-2">Pas encore...</h1>
        <p class="text-gray-500 mb-6">Vous n'avez pas atteint la note minimale</p>
        <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6">
            <p class="text-5xl font-bold text-red-500">{{ $resultat->note }}/20</p>
            <p class="text-gray-500 mt-2">Note obtenue</p>
        </div>
        <p class="text-gray-600 text-sm mb-6">
            Note minimale requise : {{ $evaluation->note_min }}/20
        </p>
        <div class="flex gap-3 justify-center">
            <a href="{{ route('apprenant.quiz.show', $evaluation->id) }}"
               class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700">
                🔄 Réessayer
            </a>
            <a href="{{ route('apprenant.dashboard') }}"
               class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-300">
                Dashboard
            </a>
        </div>
    </div>
    @endif

</div>

@endsection