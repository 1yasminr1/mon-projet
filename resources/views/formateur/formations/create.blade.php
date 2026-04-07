@extends('layouts.formateur')
@section('title', 'Créer Formation')
@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">➕ Créer une Formation</h1>
    <p class="text-gray-500 mt-1">Remplissez les informations de votre formation</p>
</div>

<div class="bg-white rounded-xl shadow p-8 max-w-3xl">
    <form method="POST" action="{{ route('formateur.formations.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Titre de la formation *</label>
            <input type="text" name="titre" value="{{ old('titre') }}" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm"
                placeholder="Ex: Développement Web avec Laravel">
            @error('titre')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Description *</label>
            <textarea name="description" required rows="4"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm"
                placeholder="Décrivez votre formation en détail...">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Prix (€) *</label>
                <input type="number" name="prix" value="{{ old('prix', 0) }}" min="0" step="0.01" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm"
                    placeholder="0 = Gratuit">
                @error('prix')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Durée (heures)</label>
                <input type="number" name="duree" value="{{ old('duree') }}" min="1"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm"
                    placeholder="Ex: 20">
            </div>
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Sous-catégorie *</label>
            <select name="sous_categorie_id" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm">
                <option value="">-- Choisir une sous-catégorie --</option>
                @foreach($sousCategories as $sousCat)
                    <option value="{{ $sousCat->id }}" {{ old('sous_categorie_id') == $sousCat->id ? 'selected' : '' }}>
                        {{ $sousCat->categorie->nom }} → {{ $sousCat->nom }}
                    </option>
                @endforeach
            </select>
            @error('sous_categorie_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Image de couverture</label>
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-green-400 transition">
                <div class="text-3xl mb-2">🖼️</div>
                <input type="file" name="image" accept=".jpg,.jpeg,.png,.pdf"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-600">
                <p class="text-xs text-gray-400 mt-2">JPG, PNG ,pdf — Max 2MB</p>
            </div>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
            <p class="text-yellow-700 text-sm">
                ⚠️ Votre formation sera soumise à validation par l'administrateur avant d'être publiée.
            </p>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="bg-green-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-green-700">
                Créer la formation →
            </button>
            <a href="{{ route('formateur.formations.index') }}"
               class="bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-bold hover:bg-gray-300">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection