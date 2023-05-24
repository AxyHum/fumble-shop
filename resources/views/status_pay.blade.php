<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="https://fumble.local">
                <img src="/images/fumble-logo-full-black.jpg" alt="">
            </a>
            <a href="https://www.fumble-ultimate.fr/"><button class="primary-button">Accéder au site</button></a>
        </div>
    </nav>
    <header class="header">
        @if ($order->status == 'paid')
            <svg width="60" height="60" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="40" height="40" rx="20" fill="#22CD10" />
                <path d="M11 20.0435L17 27.087L29 13" stroke="white" stroke-width="2.5" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
            <h1 class="payment-title">Paiement Effectué</h1>
            <h4 class="subtitle">Votre paiement à correctement été effectué</h4>
        @else
            <svg width="60" height="60" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="40" height="40" rx="20" fill="#EA5455" />
                <path d="M27 13L13 27M13 13L27 27" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>

            <h1>Paiement Echoué</h1>
            <h4 class="subtitle">Une erreur c'est produite lors du paiement, veuillez réessayer</h4>
        @endif
    </header>
    <section class="section">
        <div class="container">
            <div class="confirm-card">
                <div class="top-content">
                    <div class="line">
                        <span>Profuit</span>
                        <span>{{ $order->product->title }}</span>
                    </div>
                    <div class="line">
                        <span>Montant</span>
                        <span>{{ number_format($order->product->price, 2) }}€</span>
                    </div>
                    <div class="line">
                        <span>Status</span>
                        @if ($order->status == 'paid')
                            <div class="badge-success">Effectué</div>
                        @else
                            <div class="badge-danger">Echoué</div>
                        @endif
                    </div>
                </div>
                <div class="bottom-content">
                    {{-- <div class="column title-column"> --}}
                    <div class="line">
                        <span>Numéro Ref</span>
                        <span># 00{{ $order->id }}</span>
                    </div>
                    <div class="line">
                        <span>Date</span>
                        <span>{{ $order->updated_at }}</span>
                    </div>
                    <div class="line">
                        <span>Paiement par</span>
                        <span>Carte bancaire</span>
                    </div>
                    <div class="line">
                        <span>Nom</span>
                        <span>{{ $order->name }}</span>
                    </div>
                    <div class="line">
                        <span>Email</span>
                        <span class="email">{{ $order->email }}</span>
                    </div>
                    <div class="column featured-column">
                    </div>
                </div>
            </div>
            <div class="button-container">
                <a class="w-100" target="_blank" href="{{ $order->invoice_pdf }}"><button
                        class="primary-outline w-100">Télécharger la
                        facture</button></a>
                <a class="w-100" href="/"><button class="primary-button w-100">Retour à
                        l'accueil</button></a>
            </div>
        </div>
    </section>
    <footer>
        <div class="footer">
            <div class="footer-left">
                <a href="#">Terms Policy</a href="#">
                <svg width="3" height="4" viewBox="0 0 3 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="1.5" cy="2" r="1.5" fill="black" />
                </svg>
                <a href="#">Customer Story</a href="#">
            </div>
            <span>2022-2023 Fumble Ultimate - Powered by
                <a style="font-weight:600" target="_blank" href="https://axystudio.org">AxyHum</a></span>
        </div>
    </footer>
</body>

</html>
