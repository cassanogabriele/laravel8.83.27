@include('include.header')

@if(Session::has('status'))
	<div class="alert alert-success text-center">
	{{Session::get('status')}}
	</div>
@endif

<section class="ftco-section ftco-cart">
	<div class="container">
		@if ($nbItemsCart === 0)
			<div class="alert alert-danger text-center" role="alert">
				Votre panier est vide !
			</div>
		@else
			<div class="cart">
				<div class="row">
					<div class="col-md-12 ftco-animate">
						<div class="cart-list">
							<table class="table">
								<thead class="thead-primary">
									<tr class="text-center">
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>Nom</th>
									<th>Prix</th>
									<th>Frais de livraison</th>
									<th>Quantité</th>
									<th>Total</th>
									</tr>
								</thead>
								
								<tbody class="product-list">
									@foreach ($cart as $cartInfos)
										<tr class="text-center">
											<td class="product-remove">
												<input type="hidden" value="{{ $cartInfos->product_id }}" id="product_id" name="product_id">
												
												<a href="#" class="remove-product" data-id="{{ $cartInfos->id }}">
													<span class="ion-ios-close"></span>
												</a>
											</td>
											
											<td class="image-prod">
												<a href="/article_by_reference/{{ $cartInfos->product_id }}" class="img" style="background-image:url({{ asset('storage/' . $cartInfos->product_image) }});"></a>
											</td>
											<td class="product-name">
												<h3><a href="/article_by_reference/{{ $cartInfos->product_id }}">{{$cartInfos->product_name}}</a></h3>
											</td>
											
											<td class="price">{{$cartInfos->product_price}} €</td>

											<td class="price shipping_cost" data-id="{{$cartInfos->product_id}}">{{$cartInfos->shipping_cost}} €</td>
	
											<form action="{{ route('modify_qty', ['id' => $cartInfos->id ?? 0]) }}" method="POST" id="modifierQtyForm">
												@csrf												

												<td class="quantity">
													<div class="input-group mb-3">
														<input type="number" name="quantity" id="quantity" class="quantity form-control input-number" value="{{ $cartInfos->qty }}" min="1" max="100" data-id="{{ $cartInfos->id }}">
														<input type="hidden" name="product_id" value="{{ $cartInfos->product_id }}">
													</div>
												</td>
											</form>										
	
											<td class="total product-total" data-id="{{$cartInfos->product_id}}">{{ $cartInfos->total_with_shipping }} €</td>
										</tr>
									@endforeach	      
								</tbody>				   
							</table>
						</div>
					</div>
				</div>
			
				<div class="row justify-content-center">	
					<div class="col-lg-4 mt-5 cart-wrap ftco-animate">
						<div class="cart-total mb-3">
							<h3>Total du panier</h3>

							<p class="d-flex">
								<span>Total des achats</span>
								<span id="total-without-shipping">{{ $totalCartWithoutShipping }} €</span>
							</p>
							
							<p class="d-flex">
								<span>Frais de Livraison</span>
								<span id="total-shipping">{{ $totalShipping }} €</span>
							</p>

							<hr>
							
							<p class="d-flex total-price">
								<span>Total</span>
								<span id="total-with-shipping">{{ $totalCartWithShipping }} €</span>
							</p>
						</div>
						<p><a href="{{route('payment')}}" class="btn btn-primary py-3 px-4">Payer la commande</a></p>
					</div>
				</div>
			</div>			
		@endif		
	</div>
</section>

@include('include.footer')

<script>
    var cart = {!! json_encode(session()->get('cart')) !!};
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/cartManagement.js') }}"></script>

<script>
$(document).ready(function(){
var quantitiy=0;
	$('.quantity-right-plus').click(function(e){		        
			// Stop acting like a button
			e.preventDefault();
			// Get the field name
			var quantity = parseInt($('#quantity').val());
			
			// If is not undefined
			$('#quantity').val(quantity + 1);
			// Increment		        
		});

		$('.quantity-left-minus').click(function(e){
			// Stop acting like a button
			e.preventDefault();
			// Get the field name
			var quantity = parseInt($('#quantity').val());
			
			// If is not undefined
		
			// Increment
			if(quantity>0){
				$('#quantity').val(quantity - 1);
			}
		});		    
	});
</script>
    
