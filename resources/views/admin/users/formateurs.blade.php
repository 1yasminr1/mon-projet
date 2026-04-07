@extends('layouts.admin')
@section('title', 'Gestion Formateurs')
@section('content')

<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">👨‍🏫 Gestion Formateurs</h1>
        <p class="text-gray-500 mt-1">Validez ou rejetez les candidatures</p>
    </div>
</div>

<!-- FILTRES -->
<div class="bg-white rounded-xl shadow p-4 mb-6 flex gap-3 flex-wrap">
    <a href="{{ route('admin.formateurs.index') }}"
       class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('statut') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
        Tous
    </a>
    <a href="{{ route('admin.formateurs.index') }}?statut=en_attente"
       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('statut') == 'en_attente' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
        ⏳ En attente
    </a>
    <a href="{{ route('admin.formateurs.index') }}?statut=approuve"
       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('statut') == 'approuve' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
        ✅ Approuvés
    </a>
    <a href="{{ route('admin.formateurs.index') }}?statut=rejete"
       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('statut') == 'rejete' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
        ❌ Rejetés
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Formateur</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Diplôme</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Spécialité</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Expérience</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">CV</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Statut</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($formateurs as $formateur)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center font-bold text-green-600">
                            {{ strtoupper(substr($formateur->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold">{{ $formateur->name }}</p>
                            <p class="text-xs text-gray-400">{{ $formateur->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 text-gray-600">{{ $formateur->diplome ?? 'N/A' }}</td>
                <td class="px-5 py-4 text-gray-600">{{ $formateur->specialite ?? 'N/A' }}</td>
                <td class="px-5 py-4 text-gray-600">{{ $formateur->experience ?? 0 }} ans</td>
                <td class="px-5 py-4">
                    @if($formateur->cv)
                        <a href="{{ asset('storage/'.$formateur->cv) }}" target="_blank"
                           class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-lg hover:bg-blue-200">
                            📄 Voir CV
                        </a>
                    @else
                        <span class="text-gray-400 text-xs">Aucun CV</span>
                    @endif
                </td>
                <td class="px-5 py-4">
                    @if($formateur->statut_formateur === 'en_attente')
                        <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">⏳ En attente</span>
                    @elseif($formateur->statut_formateur === 'approuve')
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">✅ Approuvé</span>
                    @else
                        <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">❌ Rejeté</span>
                    @endif
                </td>
                <td class="px-5 py-4">
                    <div class="flex gap-2 flex-wrap">
                        @if($formateur->statut_formateur === 'en_attente')
                            <form method="POST" action="{{ route('admin.formateurs.valider', $formateur->id) }}">
                                @csrf
                                <button class="bg-green-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-green-600">
                                    ✅ Valider
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.formateurs.rejeter', $formateur->id) }}">
                                @csrf
                                <button class="bg-red-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-red-600">
                                    ❌ Rejeter
                                </button>
                            </form>
                        @endif
                        @if($formateur->statut === 'actif')
                            <form method="POST" action="{{ route('admin.users.bloquer', $formateur->id) }}">
                                @csrf
                                <button class="bg-orange-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-orange-600">
                                    🔒 Bloquer
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.users.debloquer', $formateur->id) }}">
                                @csrf
                                <button class="bg-blue-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-blue-600">
                                    🔓 Débloquer
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-8 text-gray-400">Aucun formateur trouvé</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $formateurs->links() }}</div>
</div>

@endsection