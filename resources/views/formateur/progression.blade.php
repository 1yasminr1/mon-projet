@extends('layouts.formateur')
@section('title', 'Progression Apprenants')
@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">📊 Progression des Apprenants</h1>
</div>

@forelse($formations as $formation)
<div class="bg-white rounded-xl shadow mb-6">
    <div class="p-5 border-b flex justify-between items-center">
        <h2 class="font-bold text-lg">{{ $formation->titre }}</h2>
        <span class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full">
            {{ $formation->inscriptions->count() }} apprenant(s)
        </span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Apprenant</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Progression</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Statut</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Inscrit le</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-medium">Certificat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($formation->inscriptions as $inscription)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                                {{ strtoupper(substr($inscription->apprenant->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium">{{ $inscription->apprenant->name }}</p>
                                <p class="text-xs text-gray-400">{{ $inscription->apprenant->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full"
                                     style="width: {{ $inscription->progression }}%"></div>
                            </div>
                            <span class="text-xs font-semibold">{{ $inscription->progression }}%</span>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        @if($inscription->statut === 'validee')
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">✅ Validée</span>
                        @elseif($inscription->statut === 'en_attente')
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">⏳ En attente</span>
                        @else
                            <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">❌ Annulée</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-gray-500">
                        {{ $inscription->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-5 py-3">
                        @php
                            $certificat = \App\Models\Certificat::where('user_id', $inscription->user_id)
                                ->where('formation_id', $formation->id)->first();
                        @endphp
                        @if($certificat)
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">
                                🏆 Attribué
                            </span>
                        @elseif($inscription->statut === 'validee')
                            <form method="POST" action="{{ route('formateur.inscriptions.certificat.attribuer', $inscription->id) }}">
                                @csrf
                                <button class="bg-yellow-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-yellow-600">
                                    🏆 Attribuer
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400 text-xs">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-400">Aucun apprenant inscrit</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@empty
<div class="bg-white rounded-xl shadow p-8 text-center text-gray-400">
    Aucune formation validée
</div>
@endforelse

@endsection