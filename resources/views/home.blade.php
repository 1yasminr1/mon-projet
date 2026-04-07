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
<body class="bg-white text-gray-800">

<!-- NAVBAR -->
<nav class="bg-white shadow-md px-8 py-4 flex justify-between items-center sticky top-0 z-50">
  <div class="text-2xl font-bold text-blue-600">📚 E-Learn</div>
  <div class="flex gap-3 items-center">
    <a href="#formations" class="px-4 py-2 text-gray-600 hover:text-blue-600 font-medium">Formations</a>
    <a href="#categories" class="px-4 py-2 text-gray-600 hover:text-blue-600 font-medium">Catégories</a>
    @auth
    <a href="@if(auth()->user()->isAdmin()) {{ route('admin.dashboard') }} @elseif(auth()->user()->isFormateur()) {{ route('formateur.dashboard') }} @else {{ route('apprenant.dashboard') }} @endif" class="px-4 py-2 text-blue-600 font-medium hover:underline">
      👤 {{ auth()->user()->name }}
    </a>
    <form method="POST" action="{{ route('logout') }}" class="inline">
      @csrf
      <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 font-medium">🚪 Déconnexion</button>
    </form>
    @else
    <a href="/login" class="px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 font-medium">Se connecter</a>
    <a href="/register" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">S'inscrire</a>
    @endauth
  </div>
</nav>

<!-- HERO avec image simple -->
<section class="relative h-[80vh] flex items-center justify-center overflow-hidden text-center px-4">
  <img src="/images/formation.jpg" alt="Formation" class="absolute inset-0 w-full h-full object-cover">
  <div class="relative z-10">
    <h1 class="text-5xl font-bold text-white mb-4">Apprenez. Évoluez. Réussissez.</h1>
    <p class="text-lg text-white mb-8">Accédez à des centaines de formations et développez vos compétences à votre rythme.</p>
    <div class="flex justify-center gap-4 flex-wrap">
      @auth
      <a href="@if(auth()->user()->isAdmin()) {{ route('admin.dashboard') }} @elseif(auth()->user()->isFormateur()) {{ route('formateur.dashboard') }} @else {{ route('apprenant.dashboard') }} @endif" class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold text-lg hover:bg-gray-100 shadow-lg">🚀 Mon Dashboard</a>
      @else
      <a href="/register" class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold text-lg hover:bg-gray-100 shadow-lg">🚀 Commencer gratuitement</a>
      @endauth
      <a href="#formations" class="border-2 border-white text-white px-8 py-3 rounded-full font-bold text-lg hover:bg-white hover:text-blue-600">Voir les formations</a>
    </div>

    <!-- Stats -->
    <div class="flex justify-center gap-12 mt-12 flex-wrap text-white font-bold">
      <div><div class="text-4xl">{{ $stats['formations'] }}+</div><div>Formations</div></div>
      <div><div class="text-4xl">{{ $stats['apprenants'] }}+</div><div>Apprenants</div></div>
      <div><div class="text-4xl">{{ $stats['formateurs'] }}+</div><div>Formateurs</div></div>
      <div><div class="text-4xl">95%</div><div>Satisfaction</div></div>
    </div>
  </div>
</section>

<!-- CATEGORIES -->
<section id="categories" class="max-w-6xl mx-auto py-16 px-4">
  <h2 class="text-3xl font-bold text-center mb-2">Nos Catégories</h2>
  <p class="text-center text-gray-500 mb-10">Explorez nos domaines de formation</p>
  @if($categories->count() > 0)
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    @php $icons = ['💻', '📊', '🎨', '🌍', '📸', '🎵', '🏋️', '🔬', '📱', '🎓']; @endphp
    @foreach($categories as $i => $cat)
      <a href="/login" class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition border-2 border-transparent hover:border-blue-500 block">
        <div class="text-4xl mb-2">{{ $icons[$i % count($icons)] }}</div>
        <div class="font-semibold">{{ $cat->nom }}</div>
        <div class="text-xs text-gray-400 mt-1">{{ $cat->sous_categories_count }} sous-catégorie(s)</div>
      </a>
    @endforeach
  </div>
  @else
  <div class="text-center text-gray-400 py-8">
    <div class="text-5xl mb-4">📂</div>
    <p>Aucune catégorie disponible pour l'instant.</p>
  </div>
  @endif
</section>

<!-- FORMATIONS -->
<section id="formations" class="py-16 px-4 bg-white">
  <div class="max-w-6xl mx-auto">
    <h2 class="text-3xl font-bold text-center mb-2">Formations Disponibles</h2>
    <p class="text-center text-gray-500 mb-10">Découvrez nos formations validées</p>

    @if($formations->count() > 0)
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($formations as $formation)
          <div class="bg-white rounded-xl shadow hover:shadow-xl transition overflow-hidden">

            {{-- IMAGE OU PDF --}}
            @if($formation->image)
              @php
                $ext = strtolower(pathinfo($formation->image, PATHINFO_EXTENSION));
              @endphp

              @if($ext === 'pdf')
                {{-- Affiche le PDF dans un iframe intégré --}}
                <iframe src="{{ asset('storage/'.$formation->image) }}" 
                        class="w-full h-40 border-none"
                        style="pointer-events: none;">
                </iframe>
              @else
                {{-- Affiche l'image --}}
                <img src="{{ asset('storage/'.$formation->image) }}" 
                     class="w-full h-40 object-cover">
              @endif
            @else
              {{-- Placeholder si pas d'image --}}
              <div class="bg-blue-400 h-40 flex items-center justify-center text-5xl text-white">
                📚
              </div>
            @endif

            {{-- INFO FORMATION --}}
            <div class="p-5">
              <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full font-medium">
                {{ $formation->sousCategorie->nom ?? 'N/A' }}
              </span>

              <h3 class="font-bold text-lg mt-2">{{ $formation->titre }}</h3>

              <p class="text-gray-500 text-sm mt-1">
                {{ Str::limit($formation->description, 80) }}
              </p>

              <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                <span>👨‍🏫 {{ $formation->formateur->name }}</span>
                @if($formation->duree)<span>⏱️ {{ $formation->duree }}h</span>@endif
                <span>👥 {{ $formation->inscriptions->count() }}</span>
              </div>

              <div class="flex justify-between items-center mt-4">
                <span class="font-bold text-lg {{ $formation->prix == 0 ? 'text-green-600' : 'text-gray-800' }}">
                  {{ $formation->prix == 0 ? 'Gratuit' : $formation->prix.'€' }}
                </span>
                <a href="/login" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 font-medium">
                   S'inscrire →
                </a>
              </div>
            </div>

          </div>
        @endforeach
      </div>
    @else
      <p class="text-center text-gray-400">Aucune formation disponible pour le moment.</p>
    @endif

  </div>
</section>

<!-- FOOTER -->
<!-- FOOTER -->
<footer class="bg-[rgba(10,22,40,1)] text-white py-10 px-4">
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 text-center md:text-left">
    
    <!-- Explore -->
    <div>
      <h3 class="font-bold text-lg mb-3">Explore</h3>
      <ul class="space-y-1 text-gray-300">
        <li><a href="#formations" class="hover:text-blue-400">Formations</a></li>
        <li><a href="#categories" class="hover:text-blue-400">Catégories</a></li>
        <li><a href="#" class="hover:text-blue-400">Blog</a></li>
      </ul>
    </div>
    
    <!-- Company -->
    <div>
      <h3 class="font-bold text-lg mb-3">Company</h3>
      <ul class="space-y-1 text-gray-300">
        <li><a href="#" class="hover:text-blue-400">À propos</a></li>
        <li><a href="#" class="hover:text-blue-400">Carrières</a></li>
        <li><a href="#" class="hover:text-blue-400">Partenaires</a></li>
      </ul>
    </div>
    
    <!-- Contact -->
    <div>
      <h3 class="font-bold text-lg mb-3">Contact</h3>
      <ul class="space-y-1 text-gray-300">
        <li>Email: <a href="mailto:contact@elearn.com" class="hover:text-blue-400">contact@elearn.com</a></li>
        <li>Téléphone: <a href="tel:+21612345678" class="hover:text-blue-400">+216 12 345 678</a></li>
        <li>Adresse: Tunis, Tunisie</li>
      </ul>
    </div>
    
  </div>

  <div class="text-center text-gray-400 text-sm mt-8">
    © {{ date('Y') }} E-Learn Platform. Tous droits réservés.
  </div>
</footer>

</body>
</html>