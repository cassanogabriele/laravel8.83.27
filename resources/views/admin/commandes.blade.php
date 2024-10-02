@extends('layouts.appadmin')

@section('title')
    Commandes
@endsection

{{ Form::hidden('', $increment = 1 )}}

@section('contenu')
  <div class="card">
    <div class="card-body">
      <h3>Commandes</h3>

      @if(Session::has('error'))
      <div class="alert alert-danger">
        {{Session::get('error')}}
        {{Session::put('error', null)}}
      </div>
      @endif

      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table id="order-listing" class="table">
              <thead>
                <tr>
                    <th>Numéro #</th>
                    <th>Nom du client</th>
                    <th>Adresse</th>
                    <th>Panier</th>
                    <th>Id de paiement</th>
                    <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($orders as $order)
                  <tr>
                    <td>{{ $increment }}</td>
                    <td>{{ $order->nom }}</td>
                    <td>{{ $order->adresse }}</td>
                    <td>
                      @foreach ($order['panier'] as $item)
                        {{ $item->product_name.' ,' }}                        
                      @endforeach                    
                    </td>
                    <td>{{ $order->payment_id }}</td>                       
                    <td>
                      <button class="btn btn-outline-primary" onclick="window.location = '{{ route('voir_pdf', ['id' => $order->id]) }}'">Voir</button>
                    </td>
                  </tr>
                {{ Form::hidden('', $increment = $increment + 1 )}}
                @endforeach                                 
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div> 
@endsection

@section('scripts')
<script src="backend/js/data-table.js"></script>
@endsection