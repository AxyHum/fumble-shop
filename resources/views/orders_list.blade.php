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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">
    <link rel="manifest" href="/images/site.webmanifest">

    <title>Fumble Shop - Liste</title>
    <style>
        body {
            zoom: .8
        }
    </style>
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
        <div style="display: flex; margin-bottom:20px; margin-top:-30px; justify-content: center">
            <button class="primary-button active" data-status="paid">Effectué</button>
            <button class="primary-button" data-status="pending">Incomplet</button>
            <button class="primary-button" data-status="fail">Echoué</button>
        </div>
        <div class="container orders-list">
            <!-- Boutons de filtre -->


            <!-- Éléments à filtrer -->
            @foreach ($orders as $order)
                <div id="{{ $order->id }}" class="order-item"
                    data-status="{{ $order->status == 'delivery' ? 'paid' : $order->status }}">
                    <div class="icon">
                        @switch($order->status)
                            @case('paid')
                                <svg class="icon_paid" width="50" height="50" viewBox="0 0 40 41" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 20.5435L18 27.587L30 13.5" stroke="#22CD10" stroke-opacity="0.6"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <rect x="1" y="1.5" width="38" height="38" rx="7"
                                        stroke="#22CD10" stroke-opacity="0.6" stroke-width="2" />
                                </svg>
                                <svg class="icon_delivery" style="display:none" width="50" height="50"
                                    viewBox="0 0 40 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect y="0.5" width="40" height="40" rx="8" fill="#22CD10"
                                        fill-opacity="0.6" />
                                    <path
                                        d="M22 11.5V15.5C22 15.7652 22.1054 16.0196 22.2929 16.2071C22.4804 16.3946 22.7348 16.5 23 16.5H27M22 11.5H15C14.4696 11.5 13.9609 11.7107 13.5858 12.0858C13.2107 12.4609 13 12.9696 13 13.5V27.5C13 28.0304 13.2107 28.5391 13.5858 28.9142C13.9609 29.2893 14.4696 29.5 15 29.5H25C25.5304 29.5 26.0391 29.2893 26.4142 28.9142C26.7893 28.5391 27 28.0304 27 27.5V16.5M22 11.5L27 16.5M17 23.5L19 25.5L23 21.5"
                                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            @break

                            @case('pending')
                                <svg width="50" height="50" viewBox="0 0 38 39" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect y="0.5" width="38" height="38" rx="8" fill="#C8CBCE" />
                                    <path
                                        d="M16 21.5L19 19.5V14.5M10 19.5C10 20.6819 10.2328 21.8522 10.6851 22.9442C11.1374 24.0361 11.8003 25.0282 12.636 25.864C13.4718 26.6997 14.4639 27.3626 15.5558 27.8149C16.6478 28.2672 17.8181 28.5 19 28.5C20.1819 28.5 21.3522 28.2672 22.4442 27.8149C23.5361 27.3626 24.5282 26.6997 25.364 25.864C26.1997 25.0282 26.8626 24.0361 27.3149 22.9442C27.7672 21.8522 28 20.6819 28 19.5C28 18.3181 27.7672 17.1478 27.3149 16.0558C26.8626 14.9639 26.1997 13.9718 25.364 13.136C24.5282 12.3003 23.5361 11.6374 22.4442 11.1851C21.3522 10.7328 20.1819 10.5 19 10.5C17.8181 10.5 16.6478 10.7328 15.5558 11.1851C14.4639 11.6374 13.4718 12.3003 12.636 13.136C11.8003 13.9718 11.1374 14.9639 10.6851 16.0558C10.2328 17.1478 10 18.3181 10 19.5Z"
                                        stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            @break

                            @case('delivery')
                                <svg width="50" height="50" viewBox="0 0 40 41" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect y="0.5" width="40" height="40" rx="8" fill="#22CD10"
                                        fill-opacity="0.6" />
                                    <path
                                        d="M22 11.5V15.5C22 15.7652 22.1054 16.0196 22.2929 16.2071C22.4804 16.3946 22.7348 16.5 23 16.5H27M22 11.5H15C14.4696 11.5 13.9609 11.7107 13.5858 12.0858C13.2107 12.4609 13 12.9696 13 13.5V27.5C13 28.0304 13.2107 28.5391 13.5858 28.9142C13.9609 29.2893 14.4696 29.5 15 29.5H25C25.5304 29.5 26.0391 29.2893 26.4142 28.9142C26.7893 28.5391 27 28.0304 27 27.5V16.5M22 11.5L27 16.5M17 23.5L19 25.5L23 21.5"
                                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            @break

                            @default
                                <svg width="50" height="50" viewBox="0 0 40 41" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect y="0.5" width="40" height="40" rx="8" fill="#EA5455"
                                        fill-opacity="0.8" />
                                    <path d="M27 13.5L13 27.5M13 13.5L27 27.5" stroke="white" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                        @endswitch
                        <span style="font-size: 14px"># {{ $order->id }}</span>
                    </div>
                    <div class="content">
                        <span
                            class="title">{{ number_format($order->product->price, 2) . '€ - ' . ($order->status == 'paid' || $order->status == 'delivery' ? 'Effectué' : ($order->status == 'pending' ? 'Incomplet' : 'Echoué')) }}</span>
                        <span>{{ $order->name ?? 'non défini' }}</span>
                        <span>{{ $order->email ?? 'non défini' }}</span>
                        <span>{{ $order->created_at ? $order->created_at->locale('fr')->isoFormat('D MMMM YYYY [à] H:mm') : 'Date inconnue' }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <footer>
        <div class="footer">
            <div class="footer-left">
                <a href="#">Terms Policy</a href="#">
                <svg width="3" height="4" viewBox="0 0 3 4" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <circle cx="1.5" cy="2" r="1.5" fill="black" />
                </svg>
                <a href="#">Customer Story</a href="#">
            </div>
            <span class="copyright">2022-2023 Fumble Ultimate - Powered by
                <a style="font-weight:600" target="_blank" href="https://axystudio.org">AxyHum</a></span>
        </div>
    </footer>
</body>

<script type="text/javascript">
    // Fonction pour filtrer les éléments en fonction du statut sélectionné
    function filterItems(status) {
        var items = document.getElementsByClassName('order-item');

        // Parcourir les éléments et afficher/masquer en fonction du statut
        for (var i = 0; i < items.length; i++) {
            var item = items[i];

            // Vérifier si l'élément a le statut correspondant
            if (status === 'all' || item.getAttribute('data-status') === status) {
                item.style.display = 'flex'; // Afficher l'élément
            } else {
                item.style.display = 'none'; // Masquer l'élément
            }
        }
    }

    // Sélectionner tous les boutons de filtre
    var filterButtons = document.getElementsByClassName('primary-button');

    // Ajouter un gestionnaire d'événement à chaque bouton de filtre
    for (var i = 0; i < filterButtons.length; i++) {
        var button = filterButtons[i];

        button.addEventListener('click', function() {
            var status = this.getAttribute('data-status'); // Récupérer le statut du bouton
            for (var i = 0; i < filterButtons.length; i++) {
                var button = filterButtons[i];
                button.classList.remove('active')
            }
            this.classList.add('active')
            // Appliquer le filtre en fonction du statut
            filterItems(status);
        });
    }
    filterItems('paid');

    var orders_items = document.getElementsByClassName('order-item')
    for (var i = 0; i < orders_items.length; i++) {
        var item = orders_items[i];

        item.addEventListener('click', function() {
            showConfirmation(this)
        });
    }

    // Fonction pour afficher la popup de confirmation
    function showConfirmation($this) {
        var result = confirm("Confirmer la remise de la carte ?");

        if (result) {
            $this.querySelector(".icon").querySelector('.icon_paid').style.display = 'none'
            $this.querySelector(".icon").querySelector('.icon_delivery').style.display = 'block'

            fetch('/orders/' + $this.getAttribute('id') + '/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        status: 'delivery'
                    })
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Mise à jour réussie !');
                    } else {
                        console.error('Erreur lors de la mise à jour');
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la requête AJAX', error);
                });
        }
    }
</script>

</html>
