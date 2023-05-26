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
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">
    <link rel="manifest" href="/images/site.webmanifest">
    <title>Fumble Shop - Liste</title>
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
    <section class="section">
        <div class="container orders-list">
            @foreach ($orders as $order)
                <div class="order-item">
                    <div class="icon">
                        @if ($order->status == 'paid')
                            <svg width="50" height="50" viewBox="0 0 40 41" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect y="0.5" width="40" height="40" rx="8" fill="#22CD10"
                                    fill-opacity="0.6" />
                                <path d="M12 20.5435L18 27.587L30 13.5" stroke="white" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @elseif ($order->status == 'pending')
                            <svg width="50" height="50" viewBox="0 0 38 39" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect y="0.5" width="38" height="38" rx="8" fill="#C8CBCE" />
                                <path
                                    d="M16 21.5L19 19.5V14.5M10 19.5C10 20.6819 10.2328 21.8522 10.6851 22.9442C11.1374 24.0361 11.8003 25.0282 12.636 25.864C13.4718 26.6997 14.4639 27.3626 15.5558 27.8149C16.6478 28.2672 17.8181 28.5 19 28.5C20.1819 28.5 21.3522 28.2672 22.4442 27.8149C23.5361 27.3626 24.5282 26.6997 25.364 25.864C26.1997 25.0282 26.8626 24.0361 27.3149 22.9442C27.7672 21.8522 28 20.6819 28 19.5C28 18.3181 27.7672 17.1478 27.3149 16.0558C26.8626 14.9639 26.1997 13.9718 25.364 13.136C24.5282 12.3003 23.5361 11.6374 22.4442 11.1851C21.3522 10.7328 20.1819 10.5 19 10.5C17.8181 10.5 16.6478 10.7328 15.5558 11.1851C14.4639 11.6374 13.4718 12.3003 12.636 13.136C11.8003 13.9718 11.1374 14.9639 10.6851 16.0558C10.2328 17.1478 10 18.3181 10 19.5Z"
                                    stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @else
                            <svg width="50" height="50" viewBox="0 0 40 41" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect y="0.5" width="40" height="40" rx="8" fill="#EA5455"
                                    fill-opacity="0.8" />
                                <path d="M27 13.5L13 27.5M13 13.5L27 27.5" stroke="white" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @endif
                    </div>
                    <div class="content">
                        <span
                            class="title">{{ number_format($order->product->price, 2) . '€ - ' . ($order->status == 'paid' ? 'Effectué' : ($order->status == 'pending' ? 'Incomplet' : 'Echoué')) }}</span>
                        <span>{{ $order->name ?? 'non défini' }}</span>
                        <span>{{ $order->email ?? 'non défini' }}</span>
                        <span>{{ $order->updated_at ? $order->updated_at->locale('fr')->isoFormat('D MMMM YYYY [à] H:mm') : 'Date inconnue' }}</span>
                    </div>
                </div>
            @endforeach
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
            <span class="copyright">2022-2023 Fumble Ultimate - Powered by
                <a style="font-weight:600" target="_blank" href="https://axystudio.org">AxyHum</a></span>
        </div>
    </footer>
</body>

</html>
