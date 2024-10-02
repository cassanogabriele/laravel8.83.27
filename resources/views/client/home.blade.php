@extends('layouts.app1')

@if(Session::has('status'))
	<div class="alert alert-success text-center">
	{{Session::get('status')}}
	</div>
@endif

@section('contenu')	
	<section class="hero text-center font-weight-bold">
		<div class="alert alert-danger" role="alert">
		&#x26A0;  Ce site est un site de démonstration, contenant des données fictives, et ayant pour unique objectif, de présenter mes compétences en Laravel.
		</div>
	</section>

	<section id="home-section" class="hero">
		<div class="home-slider owl-carousel">
			@foreach($sliders as $slider)
				<div class="slider-item" style="background-image: url(/storage/{{ $slider->slider_image}});">
					<div class="overlay"></div>
					
					<div class="container">
						<div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

						<div class="col-md-12 ftco-animate text-center">
							<h1 class="mb-2">{{ $slider->description1}}</h1>
							<h2 class="subheading mb-4">{{ $slider->description2}}</h2>
							<p><a href="/select_by_category/{{ $slider->description1 }}"class="btn btn-primary">Voir les détails</a></p>
						</div>

						</div>
					</div>
				</div>
			@endforeach			
		</div>
	  </div>
  </section>
@endsection('contenu')