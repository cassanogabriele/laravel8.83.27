@include('include.header')

<section class="ftco-section">
  <div class="container"> 
    <div class="row">
        @foreach ($orders as $order)     
            @php   
            $mois = [
                1 => '01', 2 => '02', 3 => '03', 4 => '04', 5 => '05', 6 => '06', 
                7 => '07', 8 => '08', 9 => '09', 10 => '10', 11 => '11', 12 => '12'
            ];

            // Extraire le jour, le mois et l'année de la date
            $dateParts = explode('-', substr($order->created_at, 0, 10));
            $annee = $dateParts[0];
            $moisNum = (int)$dateParts[1];
            $moisNom = $mois[$moisNum];
            $jour = $dateParts[2];    

            if($order->canceled == 0){
                $status = 'active';
            } else{
                $status = 'annulée';
            }
            @endphp 

            <div class="col-md-12 ftco-animate">
                <div class="product text-center ">
                    <p><span class="font-weight-bold">Numéro : </span> {{ $order->id }}</p>
                    <p><span class="font-weight-bold">Adresse de livraison : </span> {{ $order->adresse }}</p>                  
                    <p><span class="font-weight-bold">Status : </span> {{ $status }}</p>
                    <p><span class="font-weight-bold">Date de la commande : </span> {{ $jour }}/{{ $moisNom }}/{{ $annee }}</p>
                </div>
            </div>
        @endforeach   			
    </div>

    <div class="row mt-5">
      <div class="col text-center">
        <div class="block-27">
          <ul>
            <li><a href="#">&lt;</a></li>
            <li class="active"><span>1</span></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">&gt;</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

@include('include.footer')

<script src="{{ asset('js/infosUserManagement.js') }}"></script>
