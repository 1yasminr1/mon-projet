@extends('layouts.formateur')
@section('title', 'Modifier Formation')
@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">✏️ Modifier la Formation</h1>
</div>

<div class="bg-white rounded-xl shadow p-8 max-w-3xl">
    <form method="POST" action="{{ route('formateur.formations.update', $formation->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Titre *</label>
            <input type="text" name="titre" value="{{ old('titre', $formation->titre) }}" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm">
            @error('titre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Description *</label>
            <textarea name="description" required rows="4"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm">{{ old('description', $formation->description) }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Prix (€) *</label>
                <input type="number" name="prix" value="{{ old('prix', $formation->prix) }}" min="0" step="0.01"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Durée (heures)</label>
                <input type="number" name="duree" value="{{ old('duree', $formation->duree) }}" min="1"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm">
            </div>
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Sous-catégorie *</label>
            <select name="sous_categorie_id" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm">
                @foreach($sousCategories as $sousCat)
                    <option value="{{ $sousCat->id }}"
                        {{ $formation->sous_categorie_id == $sousCat->id ? 'selected' : '' }}>
                        {{ $sousCat->categorie->nom }} → {{ $sousCat->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Nouvelle image (optionnel)</label>
            @if($formation->image)
                <img src="{{ asset('storage/'.$formation->image) }}"
                     class="w-32 h-20 object-cover rounded-lg mb-3">
            @endif
            <input type="file" name="image" accept=".jpg,.jpeg,.png,.pdf"
                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-600">
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="bg-green-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-green-700">
                Enregistrer →
            </button>
            <a href="{{ route('formateur.formations.index') }}"
               class="bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-bold hover:bg-gray-300">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection