@extends('layouts.admin')
@section('title', 'Catégories')
@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">📂 Gestion Catégories</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- AJOUTER CATEGORIE -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="font-bold text-lg mb-4">➕ Ajouter une catégorie</h2>
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <input type="text" name="nom" placeholder="Nom de la catégorie" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-3 text-sm focus:outline-none focus:border-blue-500">
            <input type="text" name="description" placeholder="Description (optionnel)"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-3 text-sm focus:outline-none focus:border-blue-500">
            <button class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">
                Ajouter
            </button>
        </form>

        <h2 class="font-bold text-lg mt-6 mb-4">➕ Ajouter une sous-catégorie</h2>
        <form method="POST" action="{{ route('admin.souscategories.store') }}">
            @csrf
            <select name="categorie_id" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-3 text-sm focus:outline-none focus:border-blue-500">
                <option value="">-- Choisir une catégorie --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                @endforeach
            </select>
            <input type="text" name="nom" placeholder="Nom de la sous-catégorie" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-3 text-sm focus:outline-none focus:border-blue-500">
            <button class="bg-green-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-green-700">
                Ajouter
            </button>
        </form>
    </div>

    <!-- LISTE CATEGORIES -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="font-bold text-lg mb-4">📋 Liste des catégories</h2>
        @forelse($categories as $cat)
        <div class="border rounded-lg p-3 mb-3">
            <div class="flex justify-between items-center">
                <span class="font-semibold">{{ $cat->nom }}</span>
                <div class="flex gap-2">
                    <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">
                        {{ $cat->sous_categories_count }} sous-cat.
                    </span>
                    <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}"
                          onsubmit="return confirm('Supprimer cette catégorie ?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs">🗑️</button>
                    </form>
                </div>
            </div>
            @if($cat->sousCategories->count() > 0)
            <div class="mt-2 flex flex-wrap gap-1">
                @foreach($cat->sousCategories as $sous)
                <div class="flex items-center gap-1 bg-gray-100 px-2 py-1 rounded text-xs">
                    {{ $sous->nom }}
                    <form method="POST" action="{{ route('admin.souscategories.destroy', $sous->id) }}"
                          onsubmit="return confirm('Supprimer ?')">
                        @csrf @method('DELETE')
                        <button class="text-red-400 hover:text-red-600 ml-1">×</button>
                    </form>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @empty
        <p class="text-gray-400 text-sm">Aucune catégorie</p>
        @endforelse
    </div>
</div>

@endsection