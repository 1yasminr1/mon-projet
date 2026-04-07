@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<!-- HEADER -->
<div class="mb-10">
    <h1 class="text-3xl font-bold text-[rgba(10,22,40,1)]">Dashboard</h1>
    <p class="text-gray-500 mt-1">
        Bienvenue, {{ auth()->user()->name }} — Vue d'ensemble de la plateforme
    </p>
</div>

<!-- STATS CARDS -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-12">

    <div class="rounded-xl p-6 text-white shadow"
         style="background: linear-gradient(135deg, rgba(10,22,40,1), rgba(0,97,140,0.85));">
        <p class="text-sm opacity-80">Apprenants</p>
        <p class="text-3xl font-bold">{{ $stats['total_apprenants'] }}</p>
    </div>

    <div class="rounded-xl p-6 text-white shadow"
         style="background: linear-gradient(135deg, rgba(10,22,40,1), rgba(0,97,140,0.75));">
        <p class="text-sm opacity-80">Formateurs</p>
        <p class="text-3xl font-bold">{{ $stats['total_formateurs'] }}</p>
    </div>

    <div class="rounded-xl p-6 text-white shadow"
         style="background: linear-gradient(135deg, rgba(10,22,40,1), rgba(0,97,140,0.65));">
        <p class="text-sm opacity-80">Formations</p>
        <p class="text-3xl font-bold">{{ $stats['total_formations'] }}</p>
    </div>

    <div class="rounded-xl p-6 text-white shadow"
         style="background: linear-gradient(135deg, rgba(10,22,40,1), rgba(0,97,140,0.55));">
        <p class="text-sm opacity-80">Inscriptions</p>
        <p class="text-3xl font-bold">{{ $stats['total_inscriptions'] }}</p>
    </div>

</div>

<!-- GRAPHIQUE UNIQUE -->
<div class="bg-white rounded-xl shadow p-6 mb-12">
    <h3 class="font-bold mb-4 text-gray-700 text-center">
        Répartition globale de la plateforme
    </h3>

    <div class="max-w-md mx-auto">
        <canvas id="globalChart"></canvas>
    </div>
</div>

<!-- FORMATEURS & FORMATIONS EN ATTENTE -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">

    <!-- FORMATEURS -->
    <div class="bg-white rounded-xl shadow">
        <div class="flex justify-between items-center p-5 border-b">
            <h2 class="font-bold">Formateurs en attente</h2>
            <a href="{{ route('admin.formateurs.index') }}"
               class="text-sm text-blue-700 hover:underline">Voir tout</a>
        </div>

        <div class="p-5">
            @forelse($formateurs_attente as $formateur)
                <div class="flex justify-between items-center py-3 border-b last:border-0">
                    <div>
                        <p class="font-semibold">{{ $formateur->name }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $formateur->specialite }} — {{ $formateur->experience }} ans
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('admin.formateurs.valider', $formateur->id) }}">
                            @csrf
                            <button class="px-3 py-1 text-xs rounded-lg bg-green-500 text-white hover:bg-green-600">
                                Valider
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.formateurs.rejeter', $formateur->id) }}">
                            @csrf
                            <button class="px-3 py-1 text-xs rounded-lg bg-red-500 text-white hover:bg-red-600">
                                Rejeter
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400">Aucun formateur en attente</p>
            @endforelse
        </div>
    </div>

    <!-- FORMATIONS -->
    <div class="bg-white rounded-xl shadow">
        <div class="flex justify-between items-center p-5 border-b">
            <h2 class="font-bold">Formations en attente</h2>
            <a href="{{ route('admin.formations.index') }}"
               class="text-sm text-blue-700 hover:underline">Voir tout</a>
        </div>

        <div class="p-5">
            @forelse($formations_attente as $formation)
                <div class="flex justify-between items-center py-3 border-b last:border-0">
                    <div>
                        <p class="font-semibold">{{ $formation->titre }}</p>
                        <p class="text-xs text-gray-400">
                            Par {{ $formation->formateur->name }}
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('admin.formations.valider', $formation->id) }}">
                            @csrf
                            <button class="px-3 py-1 text-xs rounded-lg bg-green-500 text-white">✓</button>
                        </form>
                        <form method="POST" action="{{ route('admin.formations.rejeter', $formation->id) }}">
                            @csrf
                            <button class="px-3 py-1 text-xs rounded-lg bg-red-500 text-white">✕</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400">Aucune formation en attente</p>
            @endforelse
        </div>
    </div>

</div>

<!-- DERNIERS APPRENANTS -->
<div class="bg-white rounded-xl shadow">
    <div class="flex justify-between items-center p-5 border-b">
        <h2 class="font-bold">Derniers apprenants inscrits</h2>
        <a href="{{ route('admin.users.index') }}"
           class="text-sm text-blue-700 hover:underline">Voir tout</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-gray-500">Nom</th>
                    <th class="px-5 py-3 text-left text-gray-500">Email</th>
                    <th class="px-5 py-3 text-left text-gray-500">Statut</th>
                    <th class="px-5 py-3 text-left text-gray-500">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($derniers_apprenants as $apprenant)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium">{{ $apprenant->name }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $apprenant->email }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-1 rounded-full text-xs
                            {{ $apprenant->statut === 'actif'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($apprenant->statut) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-gray-500">
                        {{ $apprenant->created_at->format('d/m/Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-400">
                        Aucun apprenant
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('globalChart'), {
    type: 'doughnut',
    data: {
        labels: ['Apprenants', 'Formateurs', 'Formations', 'Inscriptions'],
        datasets: [{
            data: [
                {{ $stats['total_apprenants'] }},
                {{ $stats['total_formateurs'] }},
                {{ $stats['total_formations'] }},
                {{ $stats['total_inscriptions'] }}
            ],
            backgroundColor: [
                'rgba(0,97,140,0.85)',
                'rgba(10,22,40,0.9)',
                'rgba(0,97,140,0.55)',
                'rgba(10,22,40,0.65)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        plugins: {
            legend: {
                position: 'bottom'
            }
        },
        cutout: '65%'
    }
});
</script>

@endsection