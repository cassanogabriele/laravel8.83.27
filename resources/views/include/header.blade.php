<!DOCTYPE html>
<html lang="en">
  <head>
    <title>GC MARKET</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('frontend/css/open-iconic-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/animate.css')}}">    
    <link rel="stylesheet" href="{{asset('frontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/aos.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery.timepicker.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/icomoon.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
  </head>

  <body class="goto-here">
		<div class="py-1 bg-primary">
    	<div class="container">
    		<div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
	    		<div class="col-lg-12 d-block">
		    		<div class="row d-flex">	
					    <div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex justify-content-center align-items-center">
								<span class="icon-paper-plane"></span>
							</div>
							
						    <span class="text text-lowercase">gabriel_cassano@hotmail.com</span>
					    </div>

					    <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
						    <span class="text"><a class="text-light" href="https://gabriel-cassano.be/">Profil professionnel</a></span>
					    </div>
				    </div>
			    </div>
		    </div>
		  </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="{{ route('home') }}">GC MARKET</a>

	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

		 <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="{{ route('home') }}" class="nav-link">Accueil</a></li>
                <li class="nav-item active"><a href="{{ route('shop') }}" class="nav-link">Magasin</a></li>   
				
				@if(Session::has('client'))
					<li class="nav-item cta cta-colored">						
						<a href="{{ route('account') }}" class="nav-link"><i class="ion-ios-person"></i> Mon compte</a>
					</li>	 
				@endif

				<li class="nav-item cta cta-colored">
					<a href="{{ route('cart') }}" class="nav-link">
						<span class="icon-shopping_cart"></span>
						[ <span class="cart-items-count" id="cart-items-count">{{ $nbItemsCart }}</span> ]
					</a>
				</li>		

				@if(Session::has('client'))
					<li class="nav-item cta cta-colored">
						<a  href="{{ route('list_wishlist') }}" class="nav-link">
							<span class="ion-ios-heart text-warning"></span>
							<span id="wishlist-count">[{{ $nbItemsWishlist != 0 ? $nbItemsWishlist : 0}}]</span>
						</a>
					</li>	 
				@endif

				@if(Session::has('client'))
					<li class="nav-item active"><a href="{{ route('logout') }}" class="nav-link">Se déconnecter</a></li>  
				@else 
					<li class="nav-item active"><a href="{{ route('client_login') }}" class="nav-link">Se connecter</a></li>  
				@endif
	        </ul>
	      </div>
	    </div>
	</nav>