@extends('layouts.apprenant')
@section('title', 'Cours')
@section('content')

<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">📖 {{ $formation->titre }}</h1>
        <div class="flex items-center gap-2 mt-2">
            <div class="w-48 bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full"
                     style="width: {{ $inscription->progression }}%"></div>
            </div>
            <span class="text-sm text-gray-500">{{ $inscription->progression }}% complété</span>
        </div>
    </div>
    <a href="{{ route('apprenant.formations.index') }}"
       class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-300">
        ← Retour
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- MODULES SIDEBAR -->
    <div>
        <div class="bg-white rounded-xl shadow p-4">
            <h3 class="font-bold mb-3">📦 Modules du cours</h3>
            @foreach($formation->modules as $module)
            <div class="mb-3">
                <div class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg mb-1">
                    <span class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold">
                        {{ $module->ordre }}
                    </span>
                    <span class="text-sm font-semibold">{{ $module->titre }}</span>
                </div>
                @foreach($module->contenus as $contenu)
                <div class="ml-4 flex items-center gap-2 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                    @if($contenu->type === 'pdf') <span class="text-red-500">📄</span>
                    @elseif($contenu->type === 'video') <span class="text-blue-500">🎥</span>
                    @else <span class="text-green-500">🎵</span>
                    @endif
                    <span class="text-xs text-gray-600">{{ $contenu->titre }}</span>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>

        <!-- EVALUATIONS -->
        @if($formation->evaluations->count() > 0)
        <div class="bg-white rounded-xl shadow p-4 mt-4">
            <h3 class="font-bold mb-3">📝 Évaluations</h3>
            @foreach($formation->evaluations as $evaluation)
            <a href="{{ route('apprenant.quiz.show', $evaluation->id) }}"
               class="flex items-center justify-between p-3 border rounded-lg hover:border-blue-400 hover:bg-blue-50 mb-2 transition">
                <div>
                    <p class="text-sm font-medium">{{ $evaluation->titre }}</p>
                    <p class="text-xs text-gray-400">{{ $evaluation->type }} — Min: {{ $evaluation->note_min }}/20</p>
                </div>
                <span class="text-blue-600 text-xs">Passer →</span>
            </a>
            @endforeach
        </div>
        @endif
    </div>

    <!-- CONTENU PRINCIPAL -->
    <div class="md:col-span-2 space-y-4">
        @forelse($formation->modules as $module)
        <div class="bg-white rounded-xl shadow">
            <div class="p-4 border-b bg-gray-50 rounded-t-xl">
                <h3 class="font-bold">{{ $module->ordre }}. {{ $module->titre }}</h3>
                @if($module->description)
                    <p class="text-xs text-gray-500 mt-1">{{ $module->description }}</p>
                @endif
            </div>
            <div class="p-4 space-y-3">
                @forelse($module->contenus as $contenu)
                <div class="flex items-center justify-between p-3 border rounded-xl hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        @if($contenu->type === 'pdf')
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center text-xl">📄</div>
                        @elseif($contenu->type === 'video')
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-xl">🎥</div>
                        @else
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-xl">🎵</div>
                        @endif
                        <div>
                            <p class="font-medium text-sm">{{ $contenu->titre }}</p>
                            <p class="text-xs text-gray-400 capitalize">{{ $contenu->type }}</p>
                        </div>
                    </div>
                    <a href="{{ asset('storage/'.$contenu->fichier) }}" target="_blank"
                       class="bg-blue-600 text-white text-xs px-4 py-2 rounded-lg hover:bg-blue-700">
                        @if($contenu->type === 'pdf') 📄 Ouvrir
                        @elseif($contenu->type === 'video') ▶️ Voir
                        @else 🎵 Écouter
                        @endif
                    </a>
                </div>
                @empty
                <p class="text-gray-400 text-sm text-center py-4">Aucun contenu dans ce module</p>
                @endforelse
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow p-12 text-center text-gray-400">
            Aucun module disponible
        </div>
        @endforelse
    </div>
</div>

@endsection