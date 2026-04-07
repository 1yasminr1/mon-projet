@extends('layouts.apprenant')
@section('title', 'Catalogue')
@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">🔍 Catalogue des Formations</h1>
</div>

<!-- RECHERCHE ET FILTRES -->
<div class="bg-white rounded-xl shadow p-5 mb-6">
    <form method="GET" action="{{ route('apprenant.formations.index') }}"
          class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-48">
            <label class="block text-sm text-gray-600 mb-1 font-medium">Rechercher</label>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Titre ou description..."
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-blue-500">
        </div>
        <div class="min-w-40">
            <label class="block text-sm text-gray-600 mb-1 font-medium">Catégorie</label>
            <select name="categorie"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-blue-500">
                <option value="">Toutes</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('categorie') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="min-w-32">
            <label class="block text-sm text-gray-600 mb-1 font-medium">Prix</label>
            <select name="prix"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-blue-500">
                <option value="">Tous</option>
                <option value="gratuit" {{ request('prix') === 'gratuit' ? 'selected' : '' }}>Gratuit</option>
                <option value="payant" {{ request('prix') === 'payant' ? 'selected' : '' }}>Payant</option>
            </select>
        </div>
        <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700 font-medium">
            🔍 Rechercher
        </button>
        @if(request('search') || request('categorie') || request('prix'))
        <a href="{{ route('apprenant.formations.index') }}"
           class="bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm hover:bg-gray-300">
            ✕ Réinitialiser
        </a>
        @endif
    </form>
</div>

@if($formations->count() === 0)
    <div class="bg-white rounded-xl shadow p-12 text-center">
        <div class="text-6xl mb-4">📚</div>
        <h2 class="text-xl font-bold text-gray-600">Aucune formation trouvée</h2>
        <p class="text-gray-400 mt-2">Essayez avec d'autres critères</p>
    </div>
@else
    <p class="text-gray-500 text-sm mb-4">{{ $formations->total() }} formation(s) trouvée(s)</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($formations as $formation)
        <div class="bg-white rounded-xl shadow hover:shadow-xl transition overflow-hidden">

            {{-- IMAGE OU PDF --}}
            @if($formation->image)
                @php
                    $ext = strtolower(pathinfo($formation->image, PATHINFO_EXTENSION));
                @endphp

                @if($ext === 'pdf')
                    {{-- Affiche le PDF dans un iframe sans scroll --}}
                    <iframe src="{{ asset('storage/'.$formation->image) }}"
                            class="w-full h-40 border-none"
                            style="pointer-events: none; overflow: hidden;">
                    </iframe>
                @else
                    {{-- Affiche l'image --}}
                    <img src="{{ asset('storage/'.$formation->image) }}"
                         class="w-full h-40 object-cover">
                @endif
            @else
                <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-40 flex items-center justify-center text-5xl">
                    📚
                </div>
            @endif

            {{-- INFO FORMATION --}}
            <div class="p-5">
                <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full font-medium">
                    {{ $formation->sousCategorie->nom ?? 'N/A' }}
                </span>
                <h3 class="font-bold text-lg mt-2">{{ $formation->titre }}</h3>
                <p class="text-gray-500 text-sm mt-1">{{ Str::limit($formation->description, 80) }}</p>
                <div class="flex items-center gap-3 mt-3 text-xs text-gray-400">
                    <span>👨‍🏫 {{ $formation->formateur->name }}</span>
                    @if($formation->duree)
                        <span>⏱️ {{ $formation->duree }}h</span>
                    @endif
                    <span>👥 {{ $formation->inscriptions->count() }}</span>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <span class="font-bold text-lg {{ $formation->prix == 0 ? 'text-green-600' : 'text-gray-800' }}">
                        {{ $formation->prix == 0 ? 'Gratuit' : $formation->prix.'€' }}
                    </span>
                    <a href="{{ route('apprenant.formations.detail', $formation->id) }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                       Voir →
                    </a>
                </div>
            </div>

        </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $formations->links() }}</div>
@endif

@endsection