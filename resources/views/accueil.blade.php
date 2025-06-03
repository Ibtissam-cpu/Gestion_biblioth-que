<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque Numérique - Accueil</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/accueil.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <a href="/" class="logo">
                <i class="fas fa-book-reader"></i> BiblioTech
            </a>
            <nav class="nav-links">
                <a href="#fonctionnalites">Fonctionnalités</a>
                <a href="#derniers-livres">Nouveautés</a>
                <a href="#apropos">À propos</a>
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
    <section class="features" id="fonctionnalites">
        <div class="features-container">
            <div class="feature-card">
                <i class="fas fa-books"></i>
                <h3>Catalogue Riche</h3>
                <p>Des milliers de livres numériques dans tous les genres : romans, sciences, histoire, éducation et plus encore.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-search"></i>
                <h3>Recherche Avancée</h3>
                <p>Trouvez facilement vos livres par titre, auteur, catégorie ou mots-clés.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-mobile-alt"></i>
                <h3>Multi-Supports</h3>
                <p>Lisez sur ordinateur, tablette ou smartphone. Synchronisation automatique de votre progression.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-history"></i>
                <h3>Gestion des Emprunts</h3>
                <p>Suivez vos emprunts en cours, votre historique et gérez vos retours facilement.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-star"></i>
                <h3>Recommandations</h3>
                <p>Découvrez des livres personnalisés selon vos goûts et votre historique de lecture.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-clock"></i>
                <h3>Disponibilité 24/7</h3>
                <p>Accédez à la bibliothèque à tout moment, réservez et empruntez en quelques clics.</p>
            </div>
        </div>
    </section>

    <!-- Latest Books Section -->
    <section class="latest-books" id="derniers-livres">
        <h2 class="section-title">Dernières Acquisitions</h2>
        <div class="books-grid">
            @foreach($dernierLivres ?? [] as $livre)
            <div class="book-card">
                <img src="{{ $livre->image_couverture }}" alt="{{ $livre->titre }}" class="book-cover">
                <div class="book-info">
                    <h3>{{ $livre->titre }}</h3>
                    <p>{{ $livre->auteur }}</p>
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
                    <li><a href="#apropos">Notre histoire</a></li>
                    <li><a href="#equipe">Notre équipe</a></li>
                    <li><a href="#contact">Nous contacter</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Services</h4>
                <ul class="footer-links">
                    <li><a href="#catalogue">Catalogue</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#support">Support</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Légal</h4>
                <ul class="footer-links">
                    <li><a href="#confidentialite">Confidentialité</a></li>
                    <li><a href="#conditions">Conditions d'utilisation</a></li>
                    <li><a href="#cookies">Cookies</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html> 