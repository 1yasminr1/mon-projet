<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - E-Learn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white shadow-lg flex flex-col">
        <div class="p-6 border-b">
            <a href="/" class="text-2xl font-bold text-blue-600">📚 E-Learn</a>
        </div>

        <nav class="flex-1 p-4 space-y-1">
            @yield('sidebar')
        </nav>

        <div class="p-4 border-t">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-sm">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 capitalize">{{ auth()->user()->role }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left text-red-500 hover:text-red-700 text-sm font-medium">
                    🚪 Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8 overflow-auto">

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-6 flex justify-between">
                <span>✅ {{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-6">
                ❌ {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

</div>

</body>
</html>