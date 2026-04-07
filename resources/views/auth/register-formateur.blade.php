<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Candidature Formateur - E-Learn</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
body { font-family: 'Poppins', sans-serif; }
.bg-dark { background-color: rgba(10,22,40,1); }
.btn-main { background-color: rgba(0,97,140,0.15); }
.text-soft { color: rgba(120,190,230,0.9); }
.custom-file-input::-webkit-file-upload-button {
    visibility: hidden;
}
.custom-file-input::before {
    content: '📄 Choisir votre CV (PDF)';
    display: inline-block;
    background: #e0f2ff;
    border: 1px solid #90cdf4;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    outline: none;
    white-space: nowrap;
    cursor: pointer;
    font-weight: 500;
    color: #1d4ed8;
}
.custom-file-input:hover::before {
    background: #bfdbfe;
}
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
            Share your<br>
            knowledge<br>
            with learners.
        </h2>

        <p class="text-soft text-sm leading-relaxed max-w-sm">
            Devenez formateur sur LearnFlow et contribuez à la formation
            de milliers d’apprenants à travers des cours de qualité
            validés par notre équipe.
        </p>
    </div>

</div>

<!-- PARTIE BLANCHE -->
<div class="w-[60%] min-h-screen bg-white flex items-center justify-center overflow-y-auto">
    <div class="w-full max-w-lg">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            Devenir Formateur
        </h2>

        <form method="POST" action="/register/formateur"
              enctype="multipart/form-data" class="space-y-4">
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

            <input type="text" name="diplome" placeholder="Diplôme obtenu" required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm">

            <input type="text" name="specialite"
                placeholder="Spécialité / Domaine d'expertise" required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm">

            <input type="number" name="experience"
                placeholder="Années d'expérience" required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm">

            <!-- Bloc fichier moderne -->
            <div class="relative">
                <input type="file" name="cv" accept=".pdf" required 
                       class="custom-file-input w-full">
            </div>

            <button type="submit"
                class="btn-main w-full py-3 rounded-lg font-semibold text-gray-800 hover:opacity-80 transition">
                Envoyer ma candidature
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