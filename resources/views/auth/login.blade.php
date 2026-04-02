<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - E-Learn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">

<div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md">
    <div class="text-center mb-8">
        <div class="text-5xl mb-3">📚</div>
        <h1 class="text-3xl font-bold text-blue-600">E-Learn</h1>
        <p class="text-gray-500 mt-1">Connectez-vous à votre compte</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            ❌ {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2 text-sm">Adresse Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 text-sm"
                placeholder="votre@email.com">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2 text-sm">Mot de passe</label>
            <input type="password" name="password" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 text-sm"
                placeholder="••••••••">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition text-sm">
            Se connecter →
        </button>
    </form>

    <!-- Info Admin -->
    <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
        <p class="text-xs text-gray-500 font-medium mb-1">🔑 Compte Admin :</p>
        <p class="text-xs text-gray-600">Email : <span class="font-mono font-bold">admin@elearning.com</span></p>
        <p class="text-xs text-gray-600">Mdp : <span class="font-mono font-bold">admin1234</span></p>
    </div>

    <div class="mt-6 text-center space-y-2">
        <p class="text-gray-500 text-sm">
            Pas de compte apprenant ?
            <a href="/register" class="text-blue-600 font-semibold hover:underline">S'inscrire</a>
        </p>
        <p class="text-gray-500 text-sm">
            Devenir formateur ?
            <a href="/register/formateur" class="text-green-600 font-semibold hover:underline">Candidature formateur</a>
        </p>
        <p class="mt-2">
            <a href="/" class="text-gray-400 text-xs hover:underline">← Retour à l'accueil</a>
        </p>
    </div>
</div>

</body>
</html>