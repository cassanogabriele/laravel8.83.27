<!DOCTYPE html>
	<html lang="en">
		<head>
			<title>Se connecter</title>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">

			<link rel="icon" type="image/png" href="frontend/images/icons/favicon.ico"/>
			<link rel="stylesheet" href="{{asset('frontend/login/vendor/bootstrap/css/bootstrap.min.css')}}">
			<link rel="stylesheet" href="{{asset('frontend/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
			<link rel="stylesheet" href="{{asset('frontend/login/fonts/iconic/css/material-design-iconic-font.min.css')}}">
			<link rel="stylesheet" href="{{asset('frontend/login/vendor/animate/animate.css')}}">
			<link rel="stylesheet" href="{{asset('frontend/login/vendor/css-hamburgers/hamburgers.min.css')}}">
			<link rel="stylesheet" href="{{asset('frontend/login/vendor/animsition/css/animsition.min.css')}}">
			<link rel="stylesheet" href="{{asset('frontend/login/vendor/select2/select2.min.css')}}">
			<link rel="stylesheet" href="{{asset('frontend/login/vendor/daterangepicker/daterangepicker.css')}}">
			<link rel="stylesheet" href="{{asset('frontend/login/vendor/daterangepicker/daterangepicker.css')}}">
			<link rel="stylesheet" href="{{asset('frontend/login/css/util.css')}}">
			<link rel="stylesheet" href="{{asset('frontend/login/css/main.css')}}">
		</head>

		<body>
	
			<div class="limiter">
				<div class="container-login100" style="background-image: url('frontend/login/images/bg-01.jpg');">		
					<div class="wrap-login100">
						@if(Session::has('status'))
							<div class="alert alert-success text-center">
							{{Session::get('status')}}
							</div>
						@endif

						@if(count($errors) > 0)             
							@foreach($errors->all() as $error)                  
								<div class="alert alert-danger text-center">
									<li>{{$error}}</li>
								</div>    
							@endforeach
							</ul>             
						@endif
						
						<form action="/creer_compte" class="login100-form validate-form" method="POST">		
							{{csrf_field()}}
							
							<a href="{{ route('home') }}">
								<span class="login100-form-logo">
									<i class="zmdi zmdi-landscape"></i>
								</span>
							</a>

							<span class="login100-form-title p-b-34 p-t-27">
								S'inscrire
							</span>

							<div class="wrap-input100 validate-input" data-validate = "Enter nom">
								<input class="input100" type="text" name="name" placeholder="Nom">
								<span class="focus-input100" data-placeholder="&#xf207;"></span>
							</div>

							<div class="wrap-input100 validate-input" data-validate = "Enter email">
								<input class="input100" type="text" name="email" placeholder="Email">
								<span class="focus-input100" data-placeholder="&#xf207;"></span>
							</div>

							<div class="wrap-input100 validate-input" data-validate="Enter password">
								<input class="input100" type="password" name="password" placeholder="Mot de pase">
								<span class="focus-input100" data-placeholder="&#xf191;"></span>
							</div>

							<div class="contact100-form-checkbox">
								<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
								<label class="label-checkbox100" for="ckb1">
									Se souvenir de moi
								</label>
							</div>

							<div class="container-login100-form-btn">
								<button class="login100-form-btn">
									Créer
								</button>
							</div>

							<div class="text-center p-t-90">
								<a class="txt1" href="{{ route('client_login') }}">
									Avez-vous un compte ? Connectez-vous
								</a>
							</div>
						</form>
					</div>
				</div>
			</div>
	

			<div id="dropDownSelect1"></div>

			<script src="{{asset('frontend/login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
			<script src="{{asset('frontend/login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
			<script src="{{asset('frontend/login/vendor/animsition/js/animsition.min.js')}}"></script>
			<script src="{{asset('frontend/login/vendor/bootstrap/js/popper.js')}}"></script>
			<script src="{{asset('frontend/login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
			<script src="{{asset('frontend/login/vendor/select2/select2.min.js')}}"></script>
			<script src="{{asset('frontend/login/vendor/daterangepicker/moment.min.js')}}"></script>
			<script src="{{asset('frontend/login/vendor/daterangepicker/daterangepicker.js')}}"></script>
			<script src="{{asset('frontend/login/vendor/countdowntime/countdowntime.js')}}"></script>
			<script src="{{asset('frontend/login/js/main.js')}}"></script>
		</body>
	</html>