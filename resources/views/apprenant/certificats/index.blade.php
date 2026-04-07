@extends('layouts.apprenant')
@section('title', 'Mes Certificats')
@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">🏆 Mes Certificats</h1>
</div>

@forelse($certificats as $certificat)
<div class="bg-white rounded-xl shadow p-6 mb-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-yellow-100 rounded-xl flex items-center justify-center text-3xl">🏆</div>
            <div>
                <h3 class="font-bold text-lg">{{ $certificat->formation->titre }}</h3>
                <p class="text-sm text-gray-500">
                    Obtenu le {{ $certificat->date_obtention->format('d/m/Y') }}
                </p>
                <p class="text-xs text-gray-400 mt-1 font-mono">Code : {{ $certificat->code }}</p>
            </div>
        </div>
        <a href="{{ route('apprenant.certificats.telecharger', $certificat->id) }}"
           class="bg-yellow-500 text-white px-6 py-2 rounded-xl font-bold hover:bg-yellow-600">
            📥 Télécharger
        </a>
    </div>
</div>
@empty
<div class="bg-white rounded-xl shadow p-12 text-center">
    <div class="text-6xl mb-4">🏆</div>
    <h2 class="text-xl font-bold text-gray-600">Aucun certificat pour l'instant</h2>
    <p class="text-gray-400 mt-2">Complétez une formation pour obtenir votre certificat !</p>
    <a href="{{ route('apprenant.formations.index') }}"
       class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700">
        Voir les formations
    </a>
</div>
@endforelse

@endsection