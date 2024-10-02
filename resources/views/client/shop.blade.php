@include('include.header')

<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 mb-5 text-center">
        <ul class="product-category">
          <li><a href="{{ route('shop') }}" class="{{ (request()->is('shop')?'active':'') }}">Tous</a></li>           
          @foreach ($categories as $category)
          <li><a href="/select_by_category/{{ $category->category_name }}" class="{{ (request()->is('/select_by_category/'. $category->category_name)?'active':'') }}">{{ $category->category_name }}</a></li>
         @endforeach
        </ul>
      </div>
    </div>

    <div class="row">
    @foreach ($products as $product)
      <div class="col-md-6 col-lg-3 ftco-animate">
        <div class="product">
            <a href="/select_by_category/{{ $category->category_name }}" class="img-prod products"
              data-product-id="{{ $product->id }}" data-href="/article_by_reference/{{ $product->id }}"
              ><img class="img-fluid" src="{{ asset('storage/' . $product->product_image) }}" alt="Colorlib Template"></a>
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

<section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
  <div class="container py-4">
    <div class="row d-flex justify-content-center py-5">
      <div class="col-md-6">
        <h2 style="font-size: 22px;" class="mb-0">Subcribe to our Newsletter</h2>
        <span>Get e-mail updates about our latest shops and special offers</span>
      </div>
      <div class="col-md-6 d-flex align-items-center">
        <form action="#" class="subscribe-form">
          <div class="form-group d-flex">
            <input type="text" class="form-control" placeholder="Enter email address">
            <input type="submit" value="Subscribe" class="submit px-3">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

@include('include.footer')

<script src="{{ asset('js/productManagement.js') }}"></script>

<script>
function setClickedFlag() {
    localStorage.setItem('addToCartClicked', true);
}
</script>