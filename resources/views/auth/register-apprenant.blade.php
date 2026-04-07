<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Inscription Apprenant - E-Learn</title>
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
    
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-6">
            <div class="text-4xl">🎓</div>
            <h1 class="text-2xl font-bold">LearnFlow</h1>
        </div>

        <h2 class="text-4xl font-bold leading-tight mb-4">
            Elevate your<br>
            intellectual<br>
            potential.
        </h2>

        <p class="text-soft text-sm leading-relaxed max-w-sm">
            LearnFlow est une plateforme e-learning moderne qui vous permet
            d’apprendre à votre rythme grâce à des formations structurées,
            interactives et accessibles partout.
        </p>
    </div>

</div>

<!-- PARTIE BLANCHE -->
<div class="w-[60%] min-h-screen bg-white flex items-center justify-center">
    <div class="w-full max-w-md">

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Créer un compte Apprenant
        </h2>
        <p class="text-gray-500 text-sm mb-8">
            Commencez votre apprentissage gratuitement
        </p>

        <form method="POST" action="/register" class="space-y-4">
            @csrf

            <input type="text" name="name" placeholder="Nom complet" required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm">

            <input type="email" name="email" placeholder="Adresse Email" required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm">

            <input type="password" name="password" placeholder="Mot de passe" required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm">

            <input type="password" name="password_confirmation"
                placeholder="Confirmer le mot de passe" required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm">

            <button type="submit"
                class="btn-main w-full py-3 rounded-lg font-semibold text-gray-800 hover:opacity-80 transition">
                Créer mon compte
            </button>
        </form>

        <!-- Lien connexion -->
        <p class="mt-4 text-center text-sm text-gray-500">
            Déjà inscrit ?
            <a href="/login" class="font-semibold text-blue-600 hover:underline">
                Se connecter
            </a>
        </p>

    </div>
</div>

</body>
</html>