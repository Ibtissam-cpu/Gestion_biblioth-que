@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nos services</h1>
    
    <div class="row mt-4">
        <div class="col-md-4">
            <h2>Emprunts & Retours</h2>
            <p>Gérez facilement vos emprunts et retours en ligne. Suivez les dates d'échéance et renouvelez vos prêts en quelques clics.</p>
        </div>
        
        <div class="col-md-4">
            <h2>Historique</h2>
            <p>Accédez à l'historique complet de vos activités, consultez vos lectures passées et téléchargez vos reçus.</p>
        </div>
        
        <div class="col-md-4">
            <h2>Recommandations</h2>
            <p>Découvrez des ouvrages adaptés à vos centres d'intérêt grâce à notre système de recommandation personnalisé.</p>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <h2>Notifications</h2>
            <p>Restez informé grâce aux notifications automatisées concernant vos échéances, réservations et nouveautés.</p>
        </div>
    </div>
    
    <div class="footer mt-5">
        <div class="row">
            <div class="col-md-3">
                <h3>Bibliothèque</h3>
                <ul class="list-unstyled">
                    <li><a href="#">À propos</a></li>
                    <li><a href="#">Actualités</a></li>
                    <li><a href="#">Horaires d'ouverture</a></li>
                    <li><a href="#">Plan d'accès</a></li>
                </ul>
            </div>
            
            <div class="col-md-3">
                <h3>Aide</h3>
                <ul class="list-unstyled">
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Guides d'utilisation</a></li>
                    <li><a href="#">Règlement</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            
            <div class="col-md-3">
                <h3>Ressources</h3>
                <ul class="list-unstyled">
                    <li><a href="#">Bases de données</a></li>
                    <li><a href="#">Revues électroniques</a></li>
                    <li><a href="#">Archives ouvertes</a></li>
                    <li><a href="#">Thèses en ligne</a></li>
                </ul>
            </div>
            
            <div class="col-md-3">
                <h3>Légal</h3>
                <ul class="list-unstyled">
                    <li><a href="#">Conditions d'utilisation</a></li>
                    <li><a href="#">Politique de confidentialité</a></li>
                    <li><a href="#">Mentions légales</a></li>
                    <li><a href="#">Cookies</a></li>
                </ul>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-12 text-center">
                <p>© 2025 Bibliothèque - Tous droits réservés</p>
            </div>
        </div>
    </div>
</div>
@endsection