@extends('layouts.admin')
@section('title', 'Gestion Apprenants')
@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">👥 Gestion Apprenants</h1>
    <p class="text-gray-500 mt-1">Gérez les comptes apprenants</p>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Apprenant</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Email</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Inscrit le</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Statut</th>
                <th class="text-left px-5 py-4 text-gray-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <p class="font-semibold">{{ $user->name }}</p>
                    </div>
                </td>
                <td class="px-5 py-4 text-gray-500">{{ $user->email }}</td>
                <td class="px-5 py-4 text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                <td class="px-5 py-4">
                    @if($user->statut === 'actif')
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">✅ Actif</span>
                    @else
                        <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">🔒 Bloqué</span>
                    @endif
                </td>
                <td class="px-5 py-4">
                    <div class="flex gap-2">
                        @if($user->statut === 'actif')
                            <form method="POST" action="{{ route('admin.users.bloquer', $user->id) }}">
                                @csrf
                                <button class="bg-orange-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-orange-600">
                                    🔒 Bloquer
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.users.debloquer', $user->id) }}">
                                @csrf
                                <button class="bg-blue-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-blue-600">
                                    🔓 Débloquer
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                              onsubmit="return confirm('Supprimer cet apprenant ?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-red-600">
                                🗑️
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-8 text-gray-400">Aucun apprenant</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $users->links() }}</div>
</div>

@endsection