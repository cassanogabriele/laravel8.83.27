<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>A simple, clean, and responsive HTML invoice template</title>
    
    <style>
    .footer {
        text-align: right;
    }

    .text-right{
        text-align: right !important;;
    }

    .footer p {
        margin: 0;
    }

    .text-center{
        text-align: center;
    }

    .mt-3{ margin-top: 15px; }

    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
        text-align: center;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
        text-align: left;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }

    .infos_order{ vertical-align: middle; }

    #infos_order_size{ font-size: 12px; }

    .font-weight-bold{
        font-weight: bold;
    }

    .heading{ font-size: 12px; }

    .item{ font-size: 14px;}
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            @foreach ($orders as $order)
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="infos_order">
                                    <h2>GC MARKET</h2>
                                </td>

                                <td class="infos_order text-right">
                                    <div id="infos_order_size">
                                        <span>Votre Commande # :</span> {{ $order->id }}<br>
                                        <span>Créée le : {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i:s') }}</span>
                                    </div>
                                </td>                                
                            </tr>
                        </table>
                    </td>
                </tr>                
                    
                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    {{ $order->adresse }}
                                </td>
                                
                                <td>
                                    {{ $order->nom }}
                                    <br>
                                    {{ Session::get('client')->email }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <tr class="heading">
                    <td>Carte de crédit n°</td>                    
                    <td>Transaction Stripe n°</td>
                </tr>
                
                <tr class="details">
                    <td class="text-center">{{ $order->credit_card }}</td>                    
                    <td class="text-center">{{ $order->payment_id }}</td>
                </tr>
                
                <table>
                    <tr class="heading">
                        <td>Article</td>
                        <td>Quantité</td>
                        <td>Prix unitaire</td>
                        <td>Frais de livraison</td>
                        <td>Total</td>
                    </tr>

                    @foreach ($orders as $order)
                        @foreach($order['panier'] as $item)
                            <tr class="item">
                                <td>{{ $item->product_name }}</td>
                                <td class="text-right">{{ $item->qty }}</td>
                                <td class="text-right">{{ $item->product_price }} €</td>
                                <td class="text-right">{{ $item->shipping_cost }} €</td>
                                <td class="text-right">{{ $item->total_with_shipping }} €</td>
                            </tr>   
                        @endforeach  
                    @endforeach     
                </table>                  
            @endforeach     
            
            <div class="footer text-right mt-3">
                <p><strong>Total de la commande :</strong> {{ $order->totalWithoutShipping }} €</p>
                <p><strong>Frais de livraison :</strong> {{ $order->totalShipping }} €</p>
                <p><strong>Montant total :</strong> {{ $order->totalWithShipping }} €</p>
            </div>
        </div>       
    </body>
</html>
