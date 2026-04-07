<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Formateur') - E-Learn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gray-100">
<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-green-900 text-white flex flex-col fixed h-full">
        <div class="p-6 border-b border-green-700">
            <a href="/" class="text-xl font-bold text-white">📚 E-Learn</a>
            <p class="text-xs text-green-300 mt-1">Espace Formateur</p>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('formateur.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('formateur.dashboard') ? 'bg-green-600' : 'hover:bg-green-800' }}">
                <span>🏠</span> Dashboard
            </a>

            <p class="text-xs text-green-400 uppercase px-4 pt-4 pb-1">Formations</p>
            <a href="{{ route('formateur.formations.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('formateur.formations.*') ? 'bg-green-600' : 'hover:bg-green-800' }}">
                <span>📚</span> Mes Formations
            </a>
            <a href="{{ route('formateur.formations.create') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('formateur.formations.create') ? 'bg-green-600' : 'hover:bg-green-800' }}">
                <span>➕</span> Créer Formation
            </a>

            <p class="text-xs text-green-400 uppercase px-4 pt-4 pb-1">Apprenants</p>
            <a href="{{ route('formateur.progression') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('formateur.progression') ? 'bg-green-600' : 'hover:bg-green-800' }}">
                <span>📊</span> Progression
            </a>
            <a href="{{ route('formateur.inscriptions.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('formateur.inscriptions.*') ? 'bg-green-600' : 'hover:bg-green-800' }}">
    <span>📋</span> Inscriptions
    @php
        $nbInscriptions = \App\Models\Inscription::whereHas('formation', fn($q) =>
            $q->where('user_id', auth()->id()))
            ->where('statut', 'en_attente')->count();
    @endphp
    @if($nbInscriptions > 0)
        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
            {{ $nbInscriptions }}
        </span>
    @endif
</a>
        </nav>

        <div class="p-4 border-t border-green-700">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-green-600 flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-green-300">{{ auth()->user()->specialite ?? 'Formateur' }}</p>
                </div>
            </div>
            <a href="{{ route('home') }}" class="block text-green-300 hover:text-white text-sm mb-2">
                🏠 Accueil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-400 hover:text-red-300 text-sm flex items-center gap-2">
                    🚪 Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 ml-64 p-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6">
                ❌ {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>