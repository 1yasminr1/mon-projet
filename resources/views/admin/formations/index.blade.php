@extends('layouts.admin')
@section('title', 'Validation Formations')
@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">🎓 Validation des Formations</h1>
    <p class="text-gray-500 mt-1">Formations en attente de validation</p>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Formation</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Formateur</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Catégorie</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Prix</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Statut</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($formations as $formation)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-5 py-4">
                    <p class="font-semibold">{{ $formation->titre }}</p>
                    <p class="text-xs text-gray-400">{{ Str::limit($formation->description, 50) }}</p>
                </td>
                <td class="px-5 py-4 text-gray-600">{{ $formation->formateur->name }}</td>
                <td class="px-5 py-4 text-gray-600">{{ $formation->sousCategorie->nom ?? 'N/A' }}</td>
                <td class="px-5 py-4">
                    @if($formation->prix == 0)
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Gratuit</span>
                    @else
                        <span class="font-semibold">{{ $formation->prix }}€</span>
                    @endif
                </td>
                <td class="px-5 py-4">
                    @if($formation->statut === 'en_attente')
                        <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">⏳ En attente</span>
                    @elseif($formation->statut === 'validee')
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">✅ Validée</span>
                    @else
                        <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">❌ Rejetée</span>
                    @endif
                </td>
                <td class="px-5 py-4">
                    <div class="flex gap-2">
                        @if($formation->statut === 'en_attente')
                        <form method="POST" action="{{ route('admin.formations.valider', $formation->id) }}">
                            @csrf
                            <button class="bg-green-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-green-600">
                                ✅ Valider
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.formations.rejeter', $formation->id) }}">
                            @csrf
                            <button class="bg-red-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-red-600">
                                ❌ Rejeter
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-8 text-gray-400">✅ Aucune formation en attente</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection