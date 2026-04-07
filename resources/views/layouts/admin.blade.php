<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - E-Learn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gray-100">
<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-100 text-gray-800 flex flex-col fixed h-full border-r border-gray-200">
        <div class="p-6 border-b border-gray-300">
            <a href="/" class="text-xl font-bold text-gray-800">📚 E-Learn</a>
            <p class="text-xs text-gray-500 mt-1">Panel Administrateur</p>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 font-semibold' : 'hover:bg-blue-50' }}">
                <span>🏠</span> Dashboard
            </a>

            <p class="text-xs text-gray-500 uppercase px-4 pt-4 pb-1">Utilisateurs</p>
            <a href="{{ route('admin.formateurs.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.formateurs.*') ? 'bg-blue-100 font-semibold' : 'hover:bg-blue-50' }}">
                <span>👨‍🏫</span> Formateurs
                @php $nb = \App\Models\User::where('role','formateur')->where('statut_formateur','en_attente')->count(); @endphp
                @if($nb > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $nb }}</span>
                @endif
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 font-semibold' : 'hover:bg-blue-50' }}">
                <span>👥</span> Apprenants
            </a>

            <p class="text-xs text-gray-500 uppercase px-4 pt-4 pb-1">Contenu</p>
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-blue-100 font-semibold' : 'hover:bg-blue-50' }}">
                <span>📂</span> Catégories
            </a>
            <a href="{{ route('admin.formations.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.formations.*') ? 'bg-blue-100 font-semibold' : 'hover:bg-blue-50' }}">
                <span>🎓</span> Formations
                @php $nbf = \App\Models\Formation::where('statut','en_attente')->count(); @endphp
                @if($nbf > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $nbf }}</span>
                @endif
            </a>
            <a href="{{ route('admin.inscriptions.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.inscriptions.*') ? 'bg-blue-100 font-semibold' : 'hover:bg-blue-50' }}">
                <span>📋</span> Inscriptions
            </a>

            @php
                $nbNotifs = \App\Models\Notification::where('user_id', auth()->id())
                                                    ->where('lu', false)->count();
            @endphp
            @if($nbNotifs > 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-2 mb-2 text-sm text-yellow-700">
                    🔔 {{ $nbNotifs }} nouvelle(s) notification(s)
                </div>
            @endif
        </nav>

        <div class="p-4 border-t border-gray-300">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">Administrateur</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left text-red-500 hover:text-red-400 text-sm flex items-center gap-2">
                    🚪 Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 ml-64 p-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6 flex justify-between items-center">
                <span>✅ {{ session('success') }}</span>
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