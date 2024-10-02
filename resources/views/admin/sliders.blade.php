@extends('layouts.appadmin')

@section('title')
    Sliders
@endsection

{{ Form::hidden('', $increment = 1 )}}

@section('contenu')
<div class="card">
  <div class="card-body">
    <h3>Sliders</h3>
    
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <thead>
              <tr>
                  <th>Numéro #</th>
                  <th>Image</th>
                  <th>Description 1</th>
                  <th>Description 2</th>
                  <th>Status</th>
                  <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($sliders as $slider)
                <tr>
                    <td>{{ $increment }}</td>
                    <td><img src="/storage/{{ $slider->slider_image }}" alt="{{ $slider->description1 }}"</td>
                    <td>{{ $slider->description1 }}</td>
                    <td>{{ $slider->description2 }}</td>
                    <td>
                      @if($slider->status == 1)
                        <label class="badge badge-info">Activé</label>
                      @else
                        <label class="badge badge-info">Désactivé</label>
                      @endif 
                    </td>                        
                    <td>
                      <button class="btn btn-outline-primary" onclick="window.location = '{{ route('edit_slider', ['id' => $slider->id]) }}'">Modifier</button>
                      <a href= '{{ route('delete_slider', ['id' => $slider->id]) }}'" id="delete" class="btn btn-outline-danger">Supprimer</a>
                      @if($slider->status == 1)
                        <button class="btn btn-outline-warning" onclick="window.location = '{{ route('deactivate_slider', ['id' => $slider->id]) }}'">Désactiver</button>
                      @else
                       <button class="btn btn-outline-primary" onclick="window.location = '{{ route('activate_slider', ['id' => $slider->id]) }}'">Activer</button>
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