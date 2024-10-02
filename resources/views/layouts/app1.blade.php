@include('include.header')

@yield('contenu')

<section class="ftco-section">  
    <div class="container">        
        @if(Session::has('client'))
        <div class="container all-boxes mt-3">   
            <div id="recently-viewed-product">
              
            </div>

            <div id="last-order">
              
            </div>
        </div>
        @endif

        <div class="row no-gutters ftco-services mt-5">
          <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services mb-md-0 mb-4">
              <div class="icon bg-color-1 active d-flex justify-content-center align-items-center mb-2">
                    <span class="flaticon-shipped"></span>
              </div>

              <div class="media-body">
                <h3 class="heading">Livraison</h3>
                <span>Quisque in ligula aliquet</span>
              </div>
            </div>      
          </div>         

          <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services mb-md-0 mb-4">
              <div class="icon bg-color-2 d-flex justify-content-center align-items-center mb-2">
                    <span class="flaticon-diet"></span>
              </div>
              <div class="media-body">
                <h3 class="heading">Livraison rapide</h3>
                <span>Duis tincidunt lorem porttitor</span>
              </div>
            </div>    
          </div>

          <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services mb-md-0 mb-4">
              <div class="icon bg-color-3 d-flex justify-content-center align-items-center mb-2">
                    <span class="flaticon-award"></span>
              </div>
              <div class="media-body">
                <h3 class="heading">Qualité</h3>
                <span>Quisque sed erat eu erat</span>
              </div>
            </div>      
          </div>

          <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services mb-md-0 mb-4">
              <div class="icon bg-color-4 d-flex justify-content-center align-items-center mb-2">
                    <span class="flaticon-customer-service"></span>
              </div>
              <div class="media-body">
                <h3 class="heading">Assistance</h3>
                <span>Nunc eu ante id neque</span>
              </div>
            </div>      
          </div>
      </div>
    </div>
</section>

<section class="ftco-section ftco-category ftco-no-pt">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                  <div class="col-md-6 order-md-last align-items-stretch d-flex">
                      <div class="category-wrap-2 ftco-animate img align-self-stretch d-flex">
                          <div class="text text-center">
                              <h2 class="text-light">Types de produits</h2>
                              <p><a href="{{ route('shop') }}" class="btn btn-primary">Acheter maintenant</a></p>
                          </div>
                      </div>
                  </div>

                  <div class="col-md-6">
                      @foreach ($firstCategories as $category)
                        <div class="category-wrap ftco-animate img mb-4 d-flex align-items-end" style="background-image: url({{ $category->category_image }});">
                          <div class="text px-3 py-1">
                              <h2 class="mb-0"><a href="/select_by_category/{{ $category->category_name }}">{{ $category->category_name }}</a></h2>
                          </div>
                        </div>
                      @endforeach
                  </div>
                </div>
            </div>

            <div class="col-md-4">
              @foreach ($remainingCategories as $category)
                <div class="category-wrap ftco-animate img mb-4 d-flex align-items-end" style="background-image: url({{ $category->category_image }});">
                  <div class="text px-3 py-1">
                      <h2 class="mb-0"><a href="#">{{ $category->category_name }}</a></h2>
                  </div>
                </div>
              @endforeach                
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center mb-3 pb-3">
      <div class="col-md-12 heading-section text-center ftco-animate">
          <span class="subheading">Produits populaires</span>
          <h2 class="mb-4">Nos produits</h2>
          <p>Les produits les plus demandés</p>
      </div>
    </div>   		
  </div>

  <div class="container">
    <div class="row">
        @foreach ($selectedProducts as $product)
        <div class="col-md-3 ftco-animate">
            <div class="product text-center">
                <a href="/article_by_reference/{{ $product->id }}" class="img-prod products" data-product-id="{{ $product->id }}" data-href="/article_by_reference/{{ $product->id }}"><img class="img-fluid img-thumbnail square-image" src="/storage/{{$product->product_image}}" alt="{{$product->product_name}}">
                  
				  <span class="status">30%</span>
                    <div class="overlay"></div>
                </a>
                <div class="text py-3 pb-4 px-3">
                    <h3><a href="#">{{$product->product_name}}</a></h3>
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
        </div>
        @endforeach
    </div>
  </div>
</section>

<section class="ftco-section img border-top border-bottom border-dark border-3" style="background-image: url(frontend/images/categories/category-4.jpg);">
  <div class="container text-light">
    <div class="row justify-content-end">
        <div class="col-md-6 heading-section ftco-animate deal-of-the-day ftco-animate">
            <span class="subheading text-light">Le meilleur prix pour vous</span>

            <h2 class="mb-4">L'affaire du jour</h2>
            
            <p>In accumsan pharetra turpis, sit amet euismod enim laoreet id. Donec imperdiet augue a tempor vestibulum. Pellentesque nec pellentesque enim. Nunc fermentum feugiat mauris vulputate pulvinar.               
            </p>
           
            <span>155 € Seulement 110 €</a></span>      
       
            <div id="timer" class="d-flex mt-5">
                <div class="time" id="days"></div>
                <div class="time pl-3" id="hours"></div>
                <div class="time pl-3" id="minutes"></div>
                <div class="time pl-3" id="seconds"></div>
            </div>
        </div>
    </div>   		
  </div>
</section>

<section class="ftco-section testimony-section">
  <div class="container">
    <div class="row justify-content-center mb-5 pb-3">
        <div class="col-md-7 heading-section ftco-animate text-center">
            <span class="subheading">Témoignage</span>
            <h2 class="mb-4">Notre client satisfait dit : </h2>
            <p>Nulla ac interdum massa. Ut et vehicula sem, id sagittis lorem. Aenean hendrerit lorem non pellentesque gravida. </p>
        </div>
    </div>

    <div class="row ftco-animate">
        <div class="col-md-12">
          <div class="carousel-testimony owl-carousel">
            @foreach ($clients as $client)
              <div class="item">
                <div class="testimony-wrap p-4 pb-5"> 
                  <div class="user-img mb-5" style="background-image: url(storage/{{$client->client_image}})">
                    <span class="quote d-flex align-items-center justify-content-center">
                      <i class="icon-quote-left"></i>
                    </span>
                  </div>

                  <div class="text text-center">
                    <p class="mb-5 pl-4 line">{{$client->description}}</p>

                    <p class="name">{{$client->name}}</p>
                    <span class="position">{{$client->job}}</span>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
    </div>
  </div>
</section>

<hr>

<section class="ftco-section ftco-partner">
  <div class="container">
      <div class="row">
          @foreach ($randomProducts as $randomproduct)     
           <div class="col-md-3 ftco-animate">
              <div class="product">
               <img class="img-fluid img-thumbnail square-image" src="/storage/{{$randomproduct->product_image}}" alt="{{$randomproduct->product_name}}">
              </div>
            </div>
          @endforeach
      </div>
  </div>
</section>

@include('include.footer')

<script src="{{ asset('js/productManagement.js') }}"></script>


