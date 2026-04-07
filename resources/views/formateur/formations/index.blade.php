@extends('layouts.formateur')
@section('title', 'Mes Formations')
@section('content')

<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">📚 Mes Formations</h1>
        <p class="text-gray-500 mt-1">Gérez vos formations</p>
    </div>
    <a href="{{ route('formateur.formations.create') }}"
       class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 font-medium">
        ➕ Nouvelle formation
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Formation</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Catégorie</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Prix</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Apprenants</th>
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
                <td class="px-5 py-4 text-gray-500">{{ $formation->sousCategorie->nom ?? 'N/A' }}</td>
                <td class="px-5 py-4">
                    @if($formation->prix == 0)
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Gratuit</span>
                    @else
                        <span class="font-semibold">{{ $formation->prix }}€</span>
                    @endif
                </td>
                <td class="px-5 py-4 text-gray-600">
                    {{ $formation->inscriptions->count() }} apprenant(s)
                </td>
                <td class="px-5 py-4">
                    @if($formation->statut === 'validee')
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">✅ Validée</span>
                    @elseif($formation->statut === 'en_attente')
                        <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">⏳ En attente</span>
                    @else
                        <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">❌ Rejetée</span>
                    @endif
                </td>
                <td class="px-5 py-4">
                    <div class="flex gap-2 flex-wrap">
                        <a href="{{ route('formateur.formations.modules.index', $formation->id) }}"
                           class="bg-blue-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-blue-600">
                            📦 Modules
                        </a>
                        <a href="{{ route('formateur.formations.evaluations.index', $formation->id) }}"
                           class="bg-purple-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-purple-600">
                            📝 Quiz
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
                <td colspan="6" class="text-center py-8 text-gray-400">
                    Aucune formation —
                    <a href="{{ route('formateur.formations.create') }}" class="text-green-600 hover:underline">
                        Créer votre première formation
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $formations->links() }}</div>
</div>

@endsection