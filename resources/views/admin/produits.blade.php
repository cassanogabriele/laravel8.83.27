@extends('layouts.appadmin')

@section('title')
    Produits
@endsection

{{ Form::hidden('', $increment = 1 )}}

@section('contenu')
<div class="card">
  <div class="card-body">
    <h3>Produits</h3>

    @if(Session::has('status'))
      <div class="alert alert-success">
        {{Session::get('status')}}
      </div>
    @endif

    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <thead>
              <tr>
                  <th>Numéro #</th>
                  <th>Image</th>
                  <th>Nom</th>
                  <th>Catégorie</th>
                  <th>Prix</th>
                  <th>Status</th>
                  <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                  @foreach($products as $product)
                  <td>{{ $increment }}</td>
                  <td><img src="/storage/{{ $product->product_image }}" alt="{{ $product->name }}"></td>
                  <td>{{ $product->product_name }}</td>
                  <td>{{ $product->product_category }}</td>
                  <td>{{ $product->product_price }}</td>
                  <td>
                    @if($product->status == 1)
                      <label class="badge badge-info">Activé</label>
                    @else
                      <label class="badge badge-info">Désactivé</label>
                    @endif

                    
                  </td>                        
                  <td>
                    <button class="btn btn-outline-primary" onclick="window.location = '{{ route('edit_product', ['id' => $product->id]) }}'">Modifier</button>
                    <a href= '{{ route('delete_produit', ['id' => $product->id]) }}'" id="delete" class="btn btn-outline-danger">Supprimer</a>
                    @if($product->status == 1)
                      <button class="btn btn-outline-warning" onclick="window.location = '{{ route('deactivate_product', ['id' => $product->id]) }}'">Désactiver</button>
                    @else
                     <button class="btn btn-outline-primary" onclick="window.location = '{{ route('activate_product', ['id' => $product->id]) }}'">Activer</button>
                    @endif
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