@extends('layouts.appadmin')

@section('title')
    Catégories
@endsection

{{ Form::hidden('', $increment = 1 )}}

@section('contenu')
<div class="card">
  <div class="card-body">
    <h3>Catégories</h3>
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
                  <th>Nom</th>
                  <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($categories as $category)
                <tr>
                  <td>{{$category->id}}</td>
                  <td>{{$category->category_name}}</td>
                  <td>
                    <label class="badge badge-info">Activer</label>
                  </td>                         
                  <td>                    
                    <button class="btn btn-outline-primary" onclick="window.location = '{{ route('edit_category', ['id' => $category->id]) }}'">Modifier</button>
                    <a href= '{{ route('delete_category', ['id' => $category->id]) }}'" id="delete" class="btn btn-outline-danger">Supprimer</a>
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
<script src="{{ asset('backend/js/data-table.js') }}"></script>
@endsection