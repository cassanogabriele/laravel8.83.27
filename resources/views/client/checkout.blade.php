@include('include.header')

<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-7 ftco-animate">			
				<form action="{{ route('pay') }}" method="POST" class="billing-form" id="checkout-form">
					{{ csrf_field() }}
					
					<h3 class="mb-4 billing-heading">Détails de paiement</h3>

					@if(Session::has('error'))
						<div class="alert alert-danger">
						{{Session::get('error')}}
						{{Session::put('error', null)}}
						</div>
					@endif

					<div class="row align-items-end">
						<div class="col-md-12">
							<div class="form-group">
								<label for="firstname">Nom complet</label>
								<input type="text" class="form-control" id="fullname" name="fullname" required>
							</div>
						</div>
					
						<div class="col-md-12">
							<div class="form-group">
								<label for="firstname">Adresse</label>
								<input type="text" class="form-control" id="address" name="address" required>
							</div>
						</div>

						<div class="w-100"></div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="country">Titulaire de la carte</label>
								<input type="text" class="form-control" id="card-name" name="card-name" required>
							</div>
						</div>

						<div class="w-100"></div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="cart_number">Numéro de carte</label>
								<input type="text" class="form-control" id="card-number" name="card-number" required>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="streetaddress">Mois d'expiration</label>
								<input type="text" class="form-control" id="card-expiry-month" name="card-expiry-month" required>
							</div>
						</div>

						<div class="w-100"></div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label for="towncity">Année d'expiration</label>
								<input type="text" class="form-control" id="card-expiry-year" name="card-expiry-year" required>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="postcodezip">Code de sécurité</label>
								<input type="text" class="form-control" id="card-cvc" name="card-cvc" required>
							</div>
						</div>

						<div class="w-100"></div>
					</div>	         
				</div>

				<div class="col-xl-5">
					<div class="row mt-5 pt-3">
						<div class="col-md-12 d-flex mb-5">
							<div class="cart-detail cart-total p-3 p-md-4">
								<h3 class="billing-heading mb-4 font-weight-bold text-center">Total du panier</h3>	
									<p class="d-flex">
										<span>Total des achats</span>
										<span>{{ $totalCartWithoutShipping }} €</span>
									</p>	

									<p class="d-flex">
										<span>Frais de livraison</span>
										<span>{{ $totalShipping }} €</span>
									</p>
									
									<hr>

									<p class="d-flex total-price">
										<span>Total</span>
										<span>{{ $totalCartWithShipping }} €</span>
									</p>
								</div>
						</div>

						<div class="col-md-12">
							<div class="cart-detail p-3 p-md-4">
								<div class="form-group">
									<div class="col-md-12">
										<input type="submit" class="btn btn-primary" value="Payer">
									</div>
								</div>
											
							</div>
						</div>
					</div>
				</form>
			</div> 
		</div>
	</div>
</section> 

@include('include.footer')

<script src="https://js.stripe.com/v2/"></script>
<script src="src/js/checkout.js"></script>   
<script>
	$(document).ready(function(){
		var quantitiy=0;

		$('.quantity-right-plus').click(function(e){	
			e.preventDefault();
		
			var quantity = parseInt($('#quantity').val());
			
			$('#quantity').val(quantity + 1);	
		});

		$('.quantity-left-minus').click(function(e){		
			e.preventDefault();
		
			var quantity = parseInt($('#quantity').val());
				
			if(quantity>0){
				$('#quantity').val(quantity - 1);
			}
		});		
	});
</script>