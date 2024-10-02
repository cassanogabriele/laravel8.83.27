@extends('layouts.appadmin')

@section('title')
Tableau de bord
@endsection

@section('contenu')
<div class="row">
  <div class="col-md-12 grid-margin">
    <div class="row">
      <div class="col-12 col-xl-5 mb-4 mb-xl-0">
        <h4 class="font-weight-bold">Bonjour  {{ Auth::user()->name }}</h4>
        <h4 class="font-weight-normal mb-0">Bienvenue sur ton espace administrateur</h4>
      </div>
    </div>

    <div class="row mt-5 mb-5">
      <div class="col-md-12"> <!-- Utilisez la classe 'col-md-12' pour rendre le jumbotron très large -->
        <div class="jumbotron">
          <h1 class="display-4">Toute la gestion du site</h1>
          <p class="lead">Vous pouvez, en tant qu'administrateur, modifier tous les éléments du site</p>
          <hr class="my-4">
          <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
          <p class="lead">
            <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="backend/js/dashboard.js"></script>
@endsection
