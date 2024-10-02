@include('include.header')

<section class="ftco-section ftco-partner">
    <div class="container">
        <h1 class="mb-5">{{$product->name}}</h1>

        <div class="row justify-content-center align-items-center">
            <div class="col-md-3 text-center">
                <div class="product">
                    <img class="img-fluid img-thumbnail" src="/storage/{{$product->product_image}}" alt="{{$product->product_name}}">
                </div>
            </div>
        </div>

        <div class="text py-3 pb-4 px-3 text-center">
            <h3><a href="#" class="products" data-product-id="{{$product->id}}">{{$product->product_name}}</a></h3>

            <div>
                <p class="price"><span class="mr-2">
                  <p>{{$product->product_description}}</p>
                </p>    
            </div>

            <div>
              <div class="pricing">
                <p class="price"><span class="mr-2">
                  <span>{{$product->product_price}} €</span>
                </p>    
              </div>
            </div>

            <div class="bottom-area d-flex px-3">
              <div class="m-auto d-flex">               
                <a href="/add_to_cart/{{$product->id}}" class="buy-now d-flex justify-content-center align-items-center mx-1">
                  <span><i class="ion-ios-cart"></i></span>
                </a>
                <a href="/add_to_wishlist/{{$product->id}}" class="heart d-flex justify-content-center align-items-center ">
                  <span><i class="ion-ios-heart"></i></span>
                </a>
              </div>
            </div>
        </div>
    </div>
</section>

@include('include.footer')

<script src="{{ asset('js/productManagement.js') }}"></script>
