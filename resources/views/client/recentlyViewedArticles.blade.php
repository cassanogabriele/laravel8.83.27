@include('include.header')

<section class="ftco-section">
  <div class="container"> 
    <div class="row">
        @foreach ($recentlyViewedProducts as $product)
        <div class="col-md-6 col-lg-3 ftco-animate">
            <div class="product">
                <a href="/article_by_reference/{{ $product->id }}" class="img-prod products">   
                    <img class="img-fluid" src="{{ asset('storage/' . $product->product_image) }}" alt="Colorlib Template"></a>
                
                    <div class="overlay"></div>			

                <div class="text py-3 pb-4 px-3 text-center">
                <h3>
                    <a class="img-prod products" href="#"
                    data-product-id="{{ $product->id }}" data-href="/article_by_reference/{{ $product->id }}">{{$product->product_name}}</a></h3>

                <div class="d-flex">
                    <div class="pricing">
                    <p class="price">
                        <i class="ion-ios-pricetag"></i>
                        <span class="price-sale">{{$product->product_price}} €</span>
                    </p>

                    <p class="price">
                        <i class="ion-md-plane"></i>
                        <span class="price-sale">
                        {{$product->shipping_cost}} €
                        </span>
                    </p>
                    </div>
                </div>

                <div class="bottom-area d-flex px-3">
                    <div class="m-auto d-flex">                    
                    <a href="/add_to_cart/{{$product->id}}" onClick="setClickedFlag()" class="buy-now d-flex justify-content-center align-items-center mx-1">
                        <span><i class="ion-ios-cart"></i></span>
                    </a>
                    
                    <a href="/add_to_wishlist/{{$product->id}}?add=1" onClick="setClickedFlag()" class="heart d-flex justify-content-center align-items-center ">
                        <span><i class="ion-ios-heart"></i></span>
                    </a>
                    </div>
                </div>
                </div>
            </div>
        </div>
        @endforeach   			
    </div>

    <div class="row mt-5">
      <div class="col text-center">
        <div class="block-27">
          <ul>
            <li><a href="#">&lt;</a></li>
            <li class="active"><span>1</span></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">&gt;</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

@include('include.footer')
