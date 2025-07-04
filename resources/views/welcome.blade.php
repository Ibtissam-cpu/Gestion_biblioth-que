<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque Numérique - Accueil</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <a href="/" class="logo">
                <i class="fas fa-book-reader"></i> BiblioTech
            </a>
            <nav class="nav-links">
                <a href="#features">Fonctionnalités</a>
                <a href="#latest-books">Nouveautés</a>
                <a href="#about">À propos</a>
                <a href="#contact">Contact</a>
            </nav>
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn btn-outline">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Inscription</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Découvrez notre bibliothèque numérique</h1>
            <p>Accédez à des milliers de livres numériques, gérez vos emprunts et découvrez de nouvelles lectures passionnantes.</p>
            <a href="{{ route('register') }}" class="btn btn-primary">Commencer l'aventure</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="features-container">
            <div class="feature-card">
                <i class="fas fa-book"></i>
                <h3>Large Collection</h3>
                <p>Accédez à une vaste collection de livres numériques dans tous les domaines.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-mobile-alt"></i>
                <h3>Accès Mobile</h3>
                <p>Lisez vos livres préférés où que vous soyez, sur tous vos appareils.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-clock"></i>
                <h3>24/7 Disponible</h3>
                <p>Notre bibliothèque est accessible à tout moment, jour et nuit.</p>
            </div>
        </div>
    </section>

    <!-- Latest Books Section -->
    <section class="latest-books" id="latest-books">
        <h2 class="section-title">Dernières Acquisitions</h2>
        <div class="books-grid">
            @foreach($latestBooks ?? [] as $book)
            <div class="book-card">
                <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="book-cover">
                <div class="book-info">
                    <h3>{{ $book->title }}</h3>
                    <p>{{ $book->author }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h4>À propos</h4>
                <ul class="footer-links">
                    <li><a href="#about">Notre histoire</a></li>
                    <li><a href="#team">Notre équipe</a></li>
                    <li><a href="#contact">Nous contacter</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Services</h4>
                <ul class="footer-links">
                    <li><a href="#catalog">Catalogue</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#support">Support</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Légal</h4>
                <ul class="footer-links">
                    <li><a href="#privacy">Confidentialité</a></li>
                    <li><a href="#terms">Conditions d'utilisation</a></li>
                    <li><a href="#cookies">Cookies</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>
