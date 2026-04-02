<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Candidature Formateur - E-Learn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gradient-to-br from-green-50 to-teal-100 min-h-screen flex items-center justify-center py-10">

<div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-lg">
    <div class="text-center mb-8">
        <div class="text-5xl mb-3">👨‍🏫</div>
        <h1 class="text-2xl font-bold text-green-600">Devenir Formateur</h1>
        <p class="text-gray-500 text-sm mt-1">Remplissez votre candidature — validation par l'admin requise</p>
    </div>

    <form method="POST" action="/register/formateur" enctype="multipart/form-data">
        @csrf

        <!-- Informations personnelles -->
        <div class="mb-6">
            <h3 class="font-bold text-gray-700 mb-3 pb-2 border-b">👤 Informations personnelles</h3>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2 text-sm">Nom complet</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm"
                    placeholder="Votre nom complet">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2 text-sm">Adresse Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm"
                    placeholder="votre@email.com">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2 text-sm">Mot de passe</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm"
                    placeholder="Minimum 6 caractères">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2 text-sm">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm"
                    placeholder="••••••••">
            </div>
        </div>

        <!-- Informations professionnelles -->
        <div class="mb-6">
            <h3 class="font-bold text-gray-700 mb-3 pb-2 border-b">🎓 Informations professionnelles</h3>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2 text-sm">Diplôme obtenu</label>
                <input type="text" name="diplome" value="{{ old('diplome') }}" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm"
                    placeholder="Ex: Master en Informatique, Licence en Gestion...">
                @error('diplome')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2 text-sm">Spécialité / Domaine d'expertise</label>
                <input type="text" name="specialite" value="{{ old('specialite') }}" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm"
                    placeholder="Ex: Développement Web, Design Graphique, Marketing...">
                @error('specialite')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2 text-sm">Années d'expérience</label>
                <input type="number" name="experience" value="{{ old('experience') }}" required min="0" max="50"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 text-sm"
                    placeholder="Ex: 5">
                @error('experience')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2 text-sm">CV (PDF uniquement)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-green-400 transition">
                    <div class="text-3xl mb-2">📄</div>
                    <p class="text-gray-500 text-sm mb-2">Glissez votre CV ici ou cliquez pour sélectionner</p>
                    <input type="file" name="cv" required accept=".pdf"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-600 hover:file:bg-green-100">
                    <p class="text-xs text-gray-400 mt-2">Format PDF — Max 5MB</p>
                </div>
                @error('cv')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Info validation -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
            <p class="text-yellow-700 text-sm">
                ⚠️ Votre candidature sera examinée par l'administrateur. Vous recevrez une notification après validation.
            </p>
        </div>

        <button type="submit"
            class="w-full bg-green-600 text-white py-3 rounded-xl font-bold hover:bg-green-700 transition text-sm">
            Envoyer ma candidature →
        </button>
    </form>

    <div class="mt-6 text-center space-y-2">
        <p class="text-gray-500 text-sm">
            Déjà un compte ?
            <a href="/login" class="text-blue-600 font-semibold hover:underline">Se connecter</a>
        </p>
        <p class="text-gray-500 text-sm">
            Vous êtes apprenant ?
            <a href="/register" class="text-blue-600 font-semibold hover:underline">Inscription apprenant</a>
        </p>
        <a href="/" class="text-gray-400 text-xs hover:underline block">← Retour à l'accueil</a>
    </div>
</div>

</body>
</html>