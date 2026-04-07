@extends('layouts.apprenant')
@section('title', 'Dashboard')
@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">🏠 Dashboard</h1>
    <p class="text-gray-500 mt-1">Bienvenue, {{ auth()->user()->name }} 👋</p>
</div>

<!-- STATS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-xl p-5 shadow flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl">📚</div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['formations_suivies'] }}</p>
            <p class="text-sm text-gray-500">Formations suivies</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow flex items-center gap-4">
        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-2xl">⏳</div>
        <div>
            <p class="text-2xl font-bold text-orange-600">{{ $stats['en_attente'] }}</p>
            <p class="text-sm text-gray-500">En attente</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow flex items-center gap-4">
        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-2xl">🏆</div>
        <div>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['certificats'] }}</p>
            <p class="text-sm text-gray-500">Certificats obtenus</p>
        </div>
    </div>
</div>

<!-- MES FORMATIONS -->
<div class="bg-white rounded-xl shadow mb-6">
    <div class="flex justify-between items-center p-5 border-b">
        <h2 class="font-bold text-lg">📚 Mes formations récentes</h2>
        <a href="{{ route('apprenant.formations.index') }}"
           class="bg-blue-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-700">
            🔍 Voir catalogue
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Formation</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Statut</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Progression</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inscriptions as $inscription)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium">{{ $inscription->formation->titre }}</td>
                    <td class="px-5 py-3">
                        @if($inscription->statut === 'validee')
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">✅ Validée</span>
                        @elseif($inscription->statut === 'en_attente')
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">⏳ En attente</span>
                        @else
                            <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">❌ Annulée</span>
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full"
                                     style="width: {{ $inscription->progression }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $inscription->progression }}%</span>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        @if($inscription->statut === 'validee')
                            <a href="{{ route('apprenant.formations.contenu', $inscription->formation_id) }}"
                               class="bg-blue-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-blue-600">
                                📖 Accéder
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-8 text-gray-400">
                        Aucune formation —
                        <a href="{{ route('apprenant.formations.index') }}" class="text-blue-600 hover:underline">
                            Découvrir le catalogue
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection