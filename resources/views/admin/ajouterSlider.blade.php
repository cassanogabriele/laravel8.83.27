@extends('layouts.appadmin')

@section('title')
    Ajouter slider
@endsection

@section('contenu')
<div class="row grid-margin">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Ajouter slide</h4>

          @if(Session::has('status'))
            <div class="alert alert-success">
              {{Session::get('status')}}
            </div>
          @endif

          @if(count($errors) > 0)             
              @foreach($errors->all() as $error)                  
                  <div class="alert alert-danger">
                    <li>{{$error}}</li>
                  </div>    
              @endforeach
            </ul>             
          @endif

          {!! Form::open(['action' => ['App\Http\Controllers\SliderController@sauverslider'], 'method' => 'POST', 'class' => 'cmxform', 'id' => 'commentForm', 'enctype' => 'multipart/form-data']) !!}

          {{csrf_field()}}
          <div class="form-group">
              {!! Form::label('', 'Description 1', ['for' => 'name']) !!}
              {!! Form::text('description1', '', ['class' => 'form-control', 'id' => 'description1']) !!}
          </div>  

          <div class="form-group">
            {!! Form::label('', 'Desciption 2', ['for' => 'price']) !!}
            {!! Form::text('description2', '', ['class' => 'form-control', 'id' => 'description2']) !!}
         </div>
         <div class="form-group">
            {!! Form::label('image', 'Image du produit') !!}
            {!! Form::file('slider_image', ['class' => 'form-control', 'id' => 'image']) !!}
        </div>               
       
            
          {!! Form::submit('Ajouter', ['class' => 'btn btn-primary']) !!}
          {!! Form::close() !!}   
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<!--
    <script src="backend/js/form-validation.js"></script>
    <script src="backend/js/bt-maxLength.js"></script>
-->
@endsection

