@include('include.header')

<section class="ftco-section" id="infos-order">
    <div class="container text-center">
        <div class="alert alert-danger" role="alert">
            <p>Ce site est un site de démonstration, il n'y a aucune vente réelle et je ne possède pas de plateforme de paiement payante.</p>
            <p>Le paiement est redirigé vers un compte Stripe gratuit.</p>
        </div>
    
        <div class="row justify-content-center">
            <div class="alert alert-info mt-3" role="alert">
                Un email contenant le récapitulatif de votre commande vient de vous être envoyé.
            </div>
        </div>

        <div class="d-flex justify-content-center align-items-center" id="infos">
            @foreach ($orders as $order)
                <div class="container">
                    <div class="row mt-3">
                        <div class="col">
                            <div class="top">
                                <div class="container">
                                    <div class="text-right">
                                        <span class="font-weight-bold">Votre Commande # :</span> {{ $order->id }}
                                        <br>
                                        <span class="font-weight-bold">Créée le :</span> {{ $order->created_at->format('d-m-Y H:i:s') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="row mt-3">
                        <div class="col">
                            <div class="information">
                                <div class="container">
                                    <div class="row">
                                        <div class="col text-right">
                                            <span class="font-weight-bold">Votre adresse : </span>{{ $order->adresse }}
                                        </div>
            
                                        <div class="col text-right">
                                            <span class="font-weight-bold">Votre nom : </span> {{ $order->nom }}<br>
                                            <span class="font-weight-bold">Votre email :</span> {{ Session::get('client')->email }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="row mt-3">
                        <div class="col">
                            <div class="heading">
                                <div class="container">
                                    <div class="row bg-primary text-white text-size">
                                        <div class="col">
                                            <span>Carte de crédit n°</span>
                                        </div>

                                        <div class="col">
                                            <span>Transaction Stripe n°</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="row mt-3">
                        <div class="col">
                            <div class="details">
                                <div class="container">
                                    <div class="row">
                                        <div class="col text-center">
                                            {{ $order->credit_card }}
                                        </div>
                                        <div class="col text-center">
                                            {{ $order->payment_id }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="invoice-box mt-3">
                        <table cellpadding="0" cellspacing="0">
                            @foreach ($orders as $order)        
                                <tr class="heading bg-primary text-white text-size">
                                    <td>Article</td>
                                    <td>Quantité</td>
                                    <td>Prix unitaire</td>
                                    <td>Frais de livraison</td>
                                    <td>Total</td>
                                </tr>
                            
                                @foreach ($order->panier as $item)
                                    <tr class="item text-size">
                                        <td><img class="img-fluid img-thumbnail product-images" src="/storage/{{ $item->product_image }}" alt="{{ $item->product_name }}"></td>
                                        <td class="text-right">{{ $item->qty }}</td>
                                        <td class="text-right">{{ $item->product_price }} €</td>
                                        <td class="text-right">{{ $item->shipping_cost }} €</td>
                                        <td class="text-right">{{ $item->total_with_shipping }} €</td>
                                    </tr>
                                @endforeach
        
                                <tr class="footer">
                                    <td colspan="4" class="text-right">
                                        <strong>Total de la commande :</strong>
                                    </td>
                                    <td class="text-right">{{ $order->totalAvecLivraison }} €</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>  
            @endforeach        
        </div>
    </div>
</section>

@include('include.footer')
