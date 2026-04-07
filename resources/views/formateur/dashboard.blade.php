@extends('layouts.formateur')
@section('title', 'Dashboard Formateur')
@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">🏠 Dashboard</h1>
    <p class="text-gray-500 mt-1">Bienvenue, {{ auth()->user()->name }}</p>
</div>

<!-- STATS -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl p-5 shadow flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl">📚</div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_formations'] }}</p>
            <p class="text-sm text-gray-500">Formations</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl">🎓</div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_apprenants'] }}</p>
            <p class="text-sm text-gray-500">Apprenants</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow flex items-center gap-4">
        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-2xl">✅</div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['formations_valides'] }}</p>
            <p class="text-sm text-gray-500">Validées</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow flex items-center gap-4">
        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-2xl">⏳</div>
        <div>
            <p class="text-2xl font-bold text-orange-600">{{ $stats['en_attente'] }}</p>
            <p class="text-sm text-gray-500">En attente</p>
        </div>
    </div>
</div>

<!-- MES FORMATIONS -->
<div class="bg-white rounded-xl shadow">
    <div class="flex justify-between items-center p-5 border-b">
        <h2 class="font-bold text-lg">📚 Mes dernières formations</h2>
        <a href="{{ route('formateur.formations.create') }}"
           class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-green-700">
            ➕ Nouvelle formation
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Titre</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Catégorie</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Prix</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Statut</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($formations as $formation)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium">{{ $formation->titre }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $formation->sousCategorie->nom ?? 'N/A' }}</td>
                    <td class="px-5 py-3">
                        @if($formation->prix == 0)
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Gratuit</span>
                        @else
                            {{ $formation->prix }}€
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        @if($formation->statut === 'validee')
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">✅ Validée</span>
                        @elseif($formation->statut === 'en_attente')
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">⏳ En attente</span>
                        @else
                            <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">❌ Rejetée</span>
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('formateur.formations.modules.index', $formation->id) }}"
                               class="bg-blue-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-blue-600">
                                📦 Modules
                            </a>
                            <a href="{{ route('formateur.formations.edit', $formation->id) }}"
                               class="bg-yellow-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-yellow-600">
                                ✏️
                            </a>
                            <form method="POST" action="{{ route('formateur.formations.destroy', $formation->id) }}"
                                  onsubmit="return confirm('Supprimer cette formation ?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-red-600">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-400">
                        Aucune formation —
                        <a href="{{ route('formateur.formations.create') }}" class="text-green-600 hover:underline">
                            Créer votre première formation
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection