<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Connexion - E-Learn</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body { font-family: 'Poppins', sans-serif; }
.bg-dark { background-color: rgba(10,22,40,1); }
.btn-main { background-color: rgba(0,97,140,0.15); }
.text-soft { color: rgba(120,190,230,0.9); }
</style>
</head>

<body class="min-h-screen flex">

<!-- PARTIE BLEUE -->
<div class="bg-dark text-white w-[40%] min-h-screen p-12 flex flex-col justify-center">

    <div>
        <div class="flex items-center gap-3 mb-6">
            <div class="text-4xl">🎓</div>
            <h1 class="text-2xl font-bold">LearnFlow</h1>
        </div>

        <h2 class="text-4xl font-bold leading-tight mb-4">
            Welcome<br>
            back to<br>
            learning.
        </h2>

        <p class="text-soft text-sm leading-relaxed max-w-sm">
            Accédez à votre espace personnel LearnFlow et continuez
            votre parcours d’apprentissage avec des contenus
            pédagogiques modernes et structurés.
        </p>
    </div>

</div>

<!-- PARTIE BLANCHE -->
<div class="w-[60%] min-h-screen bg-white flex items-center justify-center">

    <div class="w-full max-w-md">

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Connexion
        </h2>
        <p class="text-gray-500 text-sm mb-8">
            Connectez-vous à votre compte
        </p>

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

        <form method="POST" action="/login" class="space-y-4">
            @csrf

            <input type="email" name="email" value="{{ old('email') }}" required
                placeholder="Adresse Email"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-200 outline-none">

            @error('email')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror

            <input type="password" name="password" required
                placeholder="Mot de passe"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-blue-200 outline-none">

            @error('password')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror

            <button type="submit"
                class="btn-main w-full py-3 rounded-lg font-semibold text-gray-800 hover:opacity-80 transition">
                Se connecter
            </button>
        </form>

        <!-- LIENS -->
        <div class="mt-6 text-center text-sm space-y-2 text-gray-500">
            <p>
                Pas de compte apprenant ?
                <a href="/register" class="font-semibold text-blue-600 hover:underline">
                    S'inscrire
                </a>
            </p>
            <p>
                Devenir formateur ?
                <a href="/register/formateur" class="font-semibold text-blue-600 hover:underline">
                    Candidature formateur
                </a>
            </p>
            <p>
                <a href="/" class="text-xs text-gray-400 hover:underline">
                    ← Retour à l'accueil
                </a>
            </p>
        </div>

    </div>
</div>

</body>
</html>