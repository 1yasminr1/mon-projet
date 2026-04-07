@extends('layouts.formateur')
@section('title', 'Modules')
@section('content')

<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">📦 Modules</h1>
        <p class="text-gray-500 mt-1">Formation : <span class="font-semibold text-green-600">{{ $formation->titre }}</span></p>
    </div>
    <a href="{{ route('formateur.formations.index') }}"
       class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm">
        ← Retour
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- AJOUTER MODULE -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="font-bold text-lg mb-4">➕ Ajouter un module</h2>
        <form method="POST" action="{{ route('formateur.formations.modules.store', $formation->id) }}">
            @csrf
            <input type="text" name="titre" placeholder="Titre du module" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 mb-3 text-sm focus:outline-none focus:border-green-500">
            <textarea name="description" placeholder="Description (optionnel)" rows="2"
                class="w-full border border-gray-300 rounded-xl px-4 py-3 mb-3 text-sm focus:outline-none focus:border-green-500"></textarea>
            <button class="bg-green-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-green-700 w-full">
                Ajouter le module
            </button>
        </form>
    </div>

    <!-- LISTE MODULES -->
    <div class="space-y-4">
        @forelse($modules as $module)
        <div class="bg-white rounded-xl shadow p-5">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="font-bold">{{ $module->ordre }}. {{ $module->titre }}</h3>
                    @if($module->description)
                        <p class="text-xs text-gray-400 mt-1">{{ $module->description }}</p>
                    @endif
                </div>
                <form method="POST" action="{{ route('formateur.modules.destroy', $module->id) }}"
                      onsubmit="return confirm('Supprimer ce module ?')">
                    @csrf @method('DELETE')
                    <button class="text-red-500 hover:text-red-700 text-xs">🗑️</button>
                </form>
            </div>

            <!-- CONTENUS DU MODULE -->
            <div class="border-t pt-3 mt-3">
                <p class="text-xs font-semibold text-gray-500 mb-2">📎 Contenus :</p>
                @forelse($module->contenus as $contenu)
                <div class="flex items-center justify-between bg-gray-50 px-3 py-2 rounded-lg mb-1">
                    <div class="flex items-center gap-2">
                        @if($contenu->type === 'pdf') <span>📄</span>
                        @elseif($contenu->type === 'video') <span>🎥</span>
                        @else <span>🎵</span>
                        @endif
                        <span class="text-xs font-medium">{{ $contenu->titre }}</span>
                        <span class="text-xs text-gray-400">({{ $contenu->type }})</span>
                    </div>
                    <form method="POST" action="{{ route('formateur.contenus.destroy', $contenu->id) }}"
                          onsubmit="return confirm('Supprimer ce contenu ?')">
                        @csrf @method('DELETE')
                        <button class="text-red-400 hover:text-red-600 text-xs">×</button>
                    </form>
                </div>
                @empty
                <p class="text-xs text-gray-400">Aucun contenu</p>
                @endforelse

                <!-- AJOUTER CONTENU -->
                <form method="POST" action="{{ route('formateur.modules.contenus.store', $module->id) }}"
                      enctype="multipart/form-data" class="mt-3 border-t pt-3">
                    @csrf
                    <p class="text-xs font-semibold text-gray-500 mb-2">➕ Ajouter contenu :</p>
                    <input type="text" name="titre" placeholder="Titre du contenu" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs mb-2 focus:outline-none focus:border-green-500">
                    <select name="type" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs mb-2 focus:outline-none focus:border-green-500">
                        <option value="">-- Type --</option>
                        <option value="pdf">📄 PDF</option>
                        <option value="video">🎥 Vidéo</option>
                        <option value="audio">🎵 Audio</option>
                    </select>
                    <input type="file" name="fichier" required
                        class="w-full text-xs text-gray-500 mb-2 file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:bg-green-50 file:text-green-600">
                    <button class="bg-blue-500 text-white text-xs px-4 py-2 rounded-lg hover:bg-blue-600 w-full">
                        Téléverser
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow p-8 text-center text-gray-400">
            Aucun module — Ajoutez votre premier module !
        </div>
        @endforelse
    </div>
</div>

@endsection