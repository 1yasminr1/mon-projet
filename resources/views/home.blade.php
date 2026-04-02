<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

  <!-- NAVBAR -->
  <nav class="bg-white shadow-md px-8 py-4 flex justify-between items-center sticky top-0 z-50">
    <div class="text-2xl font-bold text-blue-600">📚 E-Learn</div>
    <div class="flex gap-3">
      <a href="#formations" class="px-4 py-2 text-gray-600 hover:text-blue-600 font-medium">Formations</a>
      <a href="#categories" class="px-4 py-2 text-gray-600 hover:text-blue-600 font-medium">Catégories</a>
      <a href="#" class="px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 font-medium">
        Se connecter
      </a>
      <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
        S'inscrire
      </a>
    </div>
  </nav>

  <!-- HERO -->
  <section class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white py-24 text-center px-4">
    <h1 class="text-5xl font-bold mb-4">Apprenez. Évoluez. Réussissez.</h1>
    <p class="text-xl mb-10 text-blue-100">
      Accédez à des centaines de formations en ligne<br>
      et développez vos compétences à votre rythme.
    </p>
    <div class="flex justify-center gap-4 flex-wrap">
      <a href="#" class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold text-lg hover:bg-gray-100 shadow-lg">
        🚀 Commencer gratuitement
      </a>
      <a href="#formations" class="border-2 border-white text-white px-8 py-3 rounded-full font-bold text-lg hover:bg-white hover:text-blue-600">
        Voir les formations
      </a>
    </div>

    <!-- Stats -->
    <div class="flex justify-center gap-12 mt-16 flex-wrap">
      <div><div class="text-4xl font-bold">500+</div><div class="text-blue-200">Formations</div></div>
      <div><div class="text-4xl font-bold">10k+</div><div class="text-blue-200">Apprenants</div></div>
      <div><div class="text-4xl font-bold">200+</div><div class="text-blue-200">Formateurs</div></div>
      <div><div class="text-4xl font-bold">95%</div><div class="text-blue-200">Satisfaction</div></div>
    </div>
  </section>

  <!-- CATEGORIES -->
  <section id="categories" class="max-w-6xl mx-auto py-16 px-4">
    <h2 class="text-3xl font-bold text-center mb-2">Nos Catégories</h2>
    <p class="text-center text-gray-500 mb-10">Explorez nos domaines de formation</p>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition cursor-pointer border-2 border-transparent hover:border-blue-500">
        <div class="text-4xl mb-2">💻</div><div class="font-semibold">Informatique</div>
      </div>
      <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition cursor-pointer border-2 border-transparent hover:border-blue-500">
        <div class="text-4xl mb-2">🎨</div><div class="font-semibold">Design</div>
      </div>
      <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition cursor-pointer border-2 border-transparent hover:border-blue-500">
        <div class="text-4xl mb-2">📊</div><div class="font-semibold">Business</div>
      </div>
      <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition cursor-pointer border-2 border-transparent hover:border-blue-500">
        <div class="text-4xl mb-2">🌍</div><div class="font-semibold">Langues</div>
      </div>
      <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition cursor-pointer border-2 border-transparent hover:border-blue-500">
        <div class="text-4xl mb-2">📸</div><div class="font-semibold">Photographie</div>
      </div>
      <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition cursor-pointer border-2 border-transparent hover:border-blue-500">
        <div class="text-4xl mb-2">🎵</div><div class="font-semibold">Musique</div>
      </div>
      <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition cursor-pointer border-2 border-transparent hover:border-blue-500">
        <div class="text-4xl mb-2">🏋️</div><div class="font-semibold">Sport & Santé</div>
      </div>
      <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition cursor-pointer border-2 border-transparent hover:border-blue-500">
        <div class="text-4xl mb-2">🔬</div><div class="font-semibold">Sciences</div>
      </div>
    </div>
  </section>

  <!-- FORMATIONS -->
  <section id="formations" class="bg-gray-100 py-16 px-4">
    <div class="max-w-6xl mx-auto">
      <h2 class="text-3xl font-bold text-center mb-2">Formations Populaires</h2>
      <p class="text-center text-gray-500 mb-10">Découvrez nos meilleures formations</p>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-xl shadow hover:shadow-xl transition overflow-hidden">
          <div class="bg-blue-500 h-40 flex items-center justify-center text-6xl">💻</div>
          <div class="p-5">
            <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full font-medium">Informatique</span>
            <h3 class="font-bold text-lg mt-2">Développement Web Complet</h3>
            <p class="text-gray-500 text-sm mt-1">Apprenez HTML, CSS, JavaScript et PHP de zéro à expert.</p>
            <div class="flex items-center gap-1 mt-2">
              <span class="text-yellow-400 text-sm">★★★★★</span>
              <span class="text-gray-400 text-sm">(120 avis)</span>
            </div>
            <div class="flex justify-between items-center mt-4">
              <span class="text-blue-600 font-bold text-lg">Gratuit</span>
              <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 font-medium">
                S'inscrire →
              </a>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow hover:shadow-xl transition overflow-hidden">
          <div class="bg-purple-500 h-40 flex items-center justify-center text-6xl">🎨</div>
          <div class="p-5">
            <span class="bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded-full font-medium">Design</span>
            <h3 class="font-bold text-lg mt-2">UI/UX Design Moderne</h3>
            <p class="text-gray-500 text-sm mt-1">Maîtrisez Figma et créez des interfaces utilisateurs professionnelles.</p>
            <div class="flex items-center gap-1 mt-2">
              <span class="text-yellow-400 text-sm">★★★★☆</span>
              <span class="text-gray-400 text-sm">(85 avis)</span>
            </div>
            <div class="flex justify-between items-center mt-4">
              <span class="text-green-600 font-bold text-lg">49€</span>
              <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 font-medium">
                S'inscrire →
              </a>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow hover:shadow-xl transition overflow-hidden">
          <div class="bg-green-500 h-40 flex items-center justify-center text-6xl">📊</div>
          <div class="p-5">
            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">Business</span>
            <h3 class="font-bold text-lg mt-2">Marketing Digital</h3>
            <p class="text-gray-500 text-sm mt-1">SEO, réseaux sociaux, publicité en ligne et stratégie digitale.</p>
            <div class="flex items-center gap-1 mt-2">
              <span class="text-yellow-400 text-sm">★★★★★</span>
              <span class="text-gray-400 text-sm">(200 avis)</span>
            </div>
            <div class="flex justify-between items-center mt-4">
              <span class="text-green-600 font-bold text-lg">79€</span>
              <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 font-medium">
                S'inscrire →
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- POURQUOI NOUS -->
  <section class="max-w-6xl mx-auto py-16 px-4">
    <h2 class="text-3xl font-bold text-center mb-10">Pourquoi nous choisir ?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
      <div>
        <div class="text-5xl mb-4">🎯</div>
        <h3 class="font-bold text-xl mb-2">Formations certifiantes</h3>
        <p class="text-gray-500">Obtenez des certificats reconnus à la fin de chaque formation.</p>
      </div>
      <div>
        <div class="text-5xl mb-4">⏰</div>
        <h3 class="font-bold text-xl mb-2">À votre rythme</h3>
        <p class="text-gray-500">Apprenez quand vous voulez, où vous voulez, sans contrainte horaire.</p>
      </div>
      <div>
        <div class="text-5xl mb-4">👨‍🏫</div>
        <h3 class="font-bold text-xl mb-2">Experts qualifiés</h3>
        <p class="text-gray-500">Nos formateurs sont des professionnels avec des années d'expérience.</p>
      </div>
    </div>
  </section>

  <!-- CTA FINAL -->
  <section class="bg-blue-600 text-white py-16 text-center px-4">
    <h2 class="text-3xl font-bold mb-4">Prêt à commencer votre apprentissage ?</h2>
    <p class="text-blue-100 mb-8 text-lg">Rejoignez plus de 10 000 apprenants satisfaits</p>
    <a href="#" class="bg-white text-blue-600 px-10 py-4 rounded-full font-bold text-lg hover:bg-gray-100 shadow-lg">
      Créer mon compte gratuitement
    </a>
  </section>

  <!-- FOOTER -->
  <footer class="bg-gray-800 text-gray-400 py-8 text-center">
    <p>© 2024 E-Learn Platform. Tous droits réservés.</p>
  </footer>

</body>
</html>