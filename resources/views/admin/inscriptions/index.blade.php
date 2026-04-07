@extends('layouts.admin')
@section('title', 'Inscriptions')
@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">📋 Gestion des Inscriptions</h1>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Apprenant</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Formation</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Statut</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Progression</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inscriptions as $inscription)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-5 py-4 font-medium">{{ $inscription->apprenant->name }}</td>
                <td class="px-5 py-4 text-gray-600">{{ $inscription->formation->titre }}</td>
                <td class="px-5 py-4">
                    @if($inscription->statut === 'validee')
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">✅ Validée</span>
                    @elseif($inscription->statut === 'en_attente')
                        <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">⏳ En attente</span>
                    @else
                        <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">❌ Annulée</span>
                    @endif
                </td>
                <td class="px-5 py-4">
                    <div class="flex items-center gap-2">
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $inscription->progression }}%"></div>
                        </div>
                        <span class="text-xs text-gray-500">{{ $inscription->progression }}%</span>
                    </div>
                </td>
                <td class="px-5 py-4 text-gray-500">{{ $inscription->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-8 text-gray-400">Aucune inscription</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $inscriptions->links() }}</div>
</div>

@endsection