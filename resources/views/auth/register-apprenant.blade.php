<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Apprenant - E-Learn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center py-10">

<div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md">
    <div class="text-center mb-8">
        <div class="text-5xl mb-3">🎓</div>
        <h1 class="text-2xl font-bold text-blue-600">Créer un compte Apprenant</h1>
        <p class="text-gray-500 text-sm mt-1">Commencez votre apprentissage gratuitement</p>
    </div>

    <form method="POST" action="/register">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2 text-sm">Nom complet</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 text-sm"
                placeholder="Votre nom complet">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2 text-sm">Adresse Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 text-sm"
                placeholder="votre@email.com">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2 text-sm">Mot de passe</label>
            <input type="password" name="password" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 text-sm"
                placeholder="Minimum 6 caractères">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2 text-sm">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required
                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 text-sm"
                placeholder="••••••••">
        </div>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition text-sm">
            Créer mon compte →
        </button>
    </form>

    <div class="mt-6 text-center space-y-2">
        <p class="text-gray-500 text-sm">
            Déjà un compte ?
            <a href="/login" class="text-blue-600 font-semibold hover:underline">Se connecter</a>
        </p>
        <p class="text-gray-500 text-sm">
            Vous êtes formateur ?
            <a href="/register/formateur" class="text-green-600 font-semibold hover:underline">Candidature formateur</a>
        </p>
        <a href="/" class="text-gray-400 text-xs hover:underline block">← Retour à l'accueil</a>
    </div>
</div>

</body>
</html>