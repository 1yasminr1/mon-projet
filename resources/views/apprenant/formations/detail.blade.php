@extends('layouts.apprenant')
@section('title', $formation->titre)
@section('content')

<div class="mb-6">
    <a href="{{ route('apprenant.formations.index') }}"
       class="text-blue-600 hover:underline text-sm">← Retour au catalogue</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- INFOS FORMATION -->
    <div class="md:col-span-2">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            @if($formation->image)
                @php
                    $ext = strtolower(pathinfo($formation->image, PATHINFO_EXTENSION));
                @endphp
                @if($ext === 'pdf')
                    {{-- Affiche le PDF de couverture sans scroll --}}
                    <iframe src="{{ asset('storage/'.$formation->image) }}" 
                            class="w-full h-48 border-none" 
                            style="pointer-events: none; overflow:hidden;"></iframe>
                @else
                    <img src="{{ asset('storage/'.$formation->image) }}" class="w-full h-48 object-cover">
                @endif
            @else
                <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-48 flex items-center justify-center text-6xl">
                    📚
                </div>
            @endif
            <div class="p-6">
                <div class="flex gap-2 mb-3">
                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">
                        {{ $formation->sousCategorie->categorie->nom ?? 'N/A' }}
                    </span>
                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                        {{ $formation->sousCategorie->nom ?? 'N/A' }}
                    </span>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $formation->titre }}</h1>
                <p class="text-gray-600 mt-3 leading-relaxed">{{ $formation->description }}</p>

                <div class="grid grid-cols-3 gap-4 mt-6 p-4 bg-gray-50 rounded-xl">
                    <div class="text-center">
                        <p class="text-xl font-bold text-blue-600">{{ $formation->modules->count() }}</p>
                        <p class="text-xs text-gray-500">Modules</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xl font-bold text-green-600">{{ $formation->duree ?? '?' }}h</p>
                        <p class="text-xs text-gray-500">Durée</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xl font-bold text-purple-600">{{ $formation->inscriptions->count() }}</p>
                        <p class="text-xs text-gray-500">Apprenants</p>
                    </div>
                </div>

                <!-- MODULES PREVIEW -->
                @if($formation->modules->count() > 0)
                <div class="mt-6">
                    <h3 class="font-bold text-lg mb-3">📦 Contenu du cours</h3>
                    @foreach($formation->modules as $module)
                    <div class="border rounded-lg p-3 mb-2">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold">
                                    {{ $module->ordre }}
                                </span>
                                <span class="text-sm font-medium">{{ $module->titre }}</span>
                            </div>
                            <span class="text-xs text-gray-400">{{ $module->contenus->count() }} fichier(s)</span>
                        </div>
                        {{-- Affichage des fichiers --}}
                        @foreach($module->contenus as $contenu)
                            @php
                                $ext = strtolower(pathinfo($contenu->fichier, PATHINFO_EXTENSION));
                            @endphp
                            @if($ext === 'pdf')
                                <iframe src="{{ asset('storage/'.$contenu->fichier) }}" 
                                        class="w-full h-40 border-none mb-2" 
                                        style="pointer-events:none; overflow:hidden;">
                                </iframe>
                            @else
                                <img src="{{ asset('storage/'.$contenu->fichier) }}" 
                                     class="w-full h-40 object-cover mb-2">
                            @endif
                        @endforeach
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- SIDEBAR INSCRIPTION -->
    <div>
        <div class="bg-white rounded-xl shadow p-6 sticky top-6">
            <div class="text-center mb-4">
                <p class="text-3xl font-bold {{ $formation->prix == 0 ? 'text-green-600' : 'text-gray-800' }}">
                    {{ $formation->prix == 0 ? 'Gratuit' : $formation->prix.'€' }}
                </p>
            </div>

            @if($inscription)
                @if($inscription->statut === 'validee')
                    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl text-center mb-3 text-sm font-medium">
                        ✅ Vous êtes inscrit
                    </div>
                    <a href="{{ route('apprenant.formations.contenu', $formation->id) }}"
                       class="block w-full bg-blue-600 text-white py-3 rounded-xl font-bold text-center hover:bg-blue-700 mb-3">
                        📖 Accéder au cours
                    </a>
                @elseif($inscription->statut === 'en_attente')
                    <div class="bg-yellow-100 text-yellow-700 px-4 py-3 rounded-xl text-center mb-3 text-sm font-medium">
                        ⏳ Inscription en attente de validation
                    </div>
                    <form method="POST" action="{{ route('apprenant.inscriptions.annuler', $inscription->id) }}">
                        @csrf
                        <button class="w-full bg-red-500 text-white py-2 rounded-xl text-sm hover:bg-red-600">
                            Annuler l'inscription
                        </button>
                    </form>
                @else
                    <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl text-center mb-3 text-sm">
                        ❌ Inscription annulée
                    </div>
                @endif
            @else
                <form method="POST" action="{{ route('apprenant.formations.inscrire', $formation->id) }}">
                    @csrf
                    <button class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 mb-3">
                        🚀 S'inscrire maintenant
                    </button>
                </form>
            @endif

            <div class="border-t pt-4 mt-2 space-y-2 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <span>👨‍🏫</span>
                    <span>{{ $formation->formateur->name }}</span>
                </div>
                @if($formation->duree)
                <div class="flex items-center gap-2">
                    <span>⏱️</span>
                    <span>{{ $formation->duree }} heures</span>
                </div>
                @endif
                <div class="flex items-center gap-2">
                    <span>📦</span>
                    <span>{{ $formation->modules->count() }} modules</span>
                </div>
                <div class="flex items-center gap-2">
                    <span>🏆</span>
                    <span>Certificat inclus</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection