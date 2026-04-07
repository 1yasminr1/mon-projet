@extends('layouts.apprenant')
@section('title', 'Certificat')
@section('content')

<div class="max-w-2xl mx-auto">

    <!-- CERTIFICAT -->
    <div class="bg-white rounded-2xl shadow-xl p-12 text-center border-4 border-yellow-400 mb-6" id="certificat">
        <div class="text-5xl mb-4">🏆</div>
        <p class="text-gray-500 text-sm uppercase tracking-widest mb-2">Certificat de Réussite</p>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">E-Learn Platform</h1>
        <div class="w-24 h-1 bg-yellow-400 mx-auto my-4"></div>
        <p class="text-gray-600 mb-4">Ce certificat est décerné à</p>
        <h2 class="text-4xl font-bold text-blue-600 mb-4">{{ $certificat->apprenant->name }}</h2>
        <p class="text-gray-600 mb-2">pour avoir complété avec succès la formation</p>
        <h3 class="text-2xl font-bold text-gray-800 mb-6">{{ $certificat->formation->titre }}</h3>
        <div class="w-24 h-1 bg-yellow-400 mx-auto my-4"></div>
        <p class="text-gray-500 text-sm">
            Délivré le {{ $certificat->date_obtention->format('d/m/Y') }}
        </p>
        <p class="text-gray-400 text-xs mt-2 font-mono">Code : {{ $certificat->code }}</p>
    </div>

    <div class="flex gap-3 justify-center">
        <button onclick="window.print()"
                class="bg-yellow-500 text-white px-8 py-3 rounded-xl font-bold hover:bg-yellow-600">
            🖨️ Imprimer / Télécharger PDF
        </button>
        <a href="{{ route('apprenant.certificats.index') }}"
           class="bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-bold hover:bg-gray-300">
            ← Retour
        </a>
    </div>
</div>

@endsection