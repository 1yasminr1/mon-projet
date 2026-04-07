@extends('layouts.formateur')
@section('title', 'Inscriptions')
@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">📋 Inscriptions à mes formations</h1>
    <p class="text-gray-500 mt-1">Validez ou refusez les demandes d'inscription</p>
</div>

<!-- FILTRES -->
<div class="bg-white rounded-xl shadow p-4 mb-6 flex gap-3 flex-wrap">
    <a href="{{ route('formateur.inscriptions.index') }}"
       class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('statut') ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-600' }}">
        Toutes
    </a>
    <a href="{{ route('formateur.inscriptions.index') }}?statut=en_attente"
       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('statut') == 'en_attente' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-600' }}">
        ⏳ En attente
        @php
            $nb = \App\Models\Inscription::whereHas('formation', fn($q) =>
                      $q->where('user_id', auth()->id()))
                      ->where('statut', 'en_attente')->count();
        @endphp
        @if($nb > 0)
            <span class="ml-1 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $nb }}</span>
        @endif
    </a>
    <a href="{{ route('formateur.inscriptions.index') }}?statut=validee"
       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('statut') == 'validee' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600' }}">
        ✅ Validées
    </a>
    <a href="{{ route('formateur.inscriptions.index') }}?statut=annulee"
       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('statut') == 'annulee' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-600' }}">
        ❌ Refusées
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Apprenant</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Formation</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Date inscription</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Statut</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inscriptions as $inscription)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600 text-sm">
                            {{ strtoupper(substr($inscription->apprenant->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold">{{ $inscription->apprenant->name }}</p>
                            <p class="text-xs text-gray-400">{{ $inscription->apprenant->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4">
                    <p class="font-medium">{{ $inscription->formation->titre }}</p>
                    <p class="text-xs text-gray-400">
                        {{ $inscription->formation->prix == 0 ? 'Gratuit' : $inscription->formation->prix.'€' }}
                    </p>
                </td>
                <td class="px-5 py-4 text-gray-500">
                    {{ $inscription->created_at->format('d/m/Y à H:i') }}
                </td>
                <td class="px-5 py-4">
                    @if($inscription->statut === 'validee')
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">✅ Validée</span>
                    @elseif($inscription->statut === 'en_attente')
                        <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">⏳ En attente</span>
                    @else
                        <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">❌ Refusée</span>
                    @endif
                </td>
                <td class="px-5 py-4">
                    @if($inscription->statut === 'en_attente')
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('formateur.inscriptions.valider', $inscription->id) }}">
                            @csrf
                            <button class="bg-green-500 text-white text-xs px-3 py-2 rounded-lg hover:bg-green-600 font-medium">
                                ✅ Valider
                            </button>
                        </form>
                        <form method="POST" action="{{ route('formateur.inscriptions.refuser', $inscription->id) }}"
                              onsubmit="return confirm('Refuser cette inscription ?')">
                            @csrf
                            <button class="bg-red-500 text-white text-xs px-3 py-2 rounded-lg hover:bg-red-600 font-medium">
                                ❌ Refuser
                            </button>
                        </form>
                    </div>
                    @elseif($inscription->statut === 'validee')
                        <div class="flex gap-2">
                            @php
                                $certificat = \App\Models\Certificat::where('user_id', $inscription->user_id)
                                    ->where('formation_id', $inscription->formation_id)->first();
                            @endphp
                            @if($certificat)
                                <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">
                                    🏆 Certificat attribué
                                </span>
                            @else
                                <form method="POST" action="{{ route('formateur.inscriptions.certificat.attribuer', $inscription->id) }}">
                                    @csrf
                                    <button class="bg-yellow-500 text-white text-xs px-3 py-2 rounded-lg hover:bg-yellow-600">
                                        🏆 Attribuer certificat
                                    </button>
                                </form>
                            @endif
                        </div>
                    @else
                        <span class="text-gray-400 text-xs">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-8 text-gray-400">
                    Aucune inscription pour l'instant
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $inscriptions->links() }}</div>
</div>

@endsection