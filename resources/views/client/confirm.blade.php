@include('include.header')

<section class="ftco-section ftco-partner">
    <div class="container">
        <h3>Articles similaires</h3>
        <div class="row">           
            <div class="col-md-8">
                <div class="row">
                    @foreach ($similarProducts as $similarProduct)
                        <div class="col-md-3 ftco-animate">
                            <div class="product text-center">
                                <a href="/article_by_reference/{{ $similarProduct->id }}" class="img-prod"><img class="img-fluid img-thumbnail square-image" src="/storage/{{$similarProduct->product_image}}" alt="{{$similarProduct->product_name}}">                               
                                    <div class="overlay"></div>
                                </a>
                                
                                <div class="text py-3 pb-4 px-3">
                                    <h3><a href="#">{{$similarProduct->product_name}}</a></h3>
                                    <div class="d-flex">
                                        <div class="pricing">
                                            <p class="price">
                                                <i class="ion-ios-pricetag"></i>
                                                <span class="price-sale">
                                                    {{$similarProduct->product_price}} €
                                                </span>
                                            </p>

                                            <p class="price">
                                                <i class="ion-md-plane"></i>
                                                <span class="price-sale">                                              {{$product->shipping_cost}} €
                                                </span>
                                              </p>
                                        </div>
                                    </div>
                                    <div class="bottom-area d-flex px-3">
                                        <div class="m-auto d-flex">                           
                                            <a href="/add_to_cart/{{$similarProduct->id}}" class="buy-now d-flex justify-content-center align-items-center mx-1">
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

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex align-items-start">
                        @if ($product)
                            <a href="/article_by_reference/{{ $product->id }}" class="img-prod">
                                <img class="img-fluid img-thumbnail small-square-image" src="/storage/{{ $product->product_image }}" alt="{{ $product->product_name }}">
                            </a>
                            <div class="ml-3">
                                <h6 class="mb-1 text-success">
                                    <i class="ion-md-checkmark"></i>
                                    Ajouté au panier
                                </h6>
                                <p class="mb-0">{{ $product->product_name }}</p>
                                <p class="mb-0">{{ $product->product_price }} €</p>
                                <p>
                                    <a href="{{ route('cart') }}" class="btn btn-primary mt-2">
                                        Voir mon panier &nbsp; <i class = "icon icon ion-ios-eye"></i>
                                    </a>
                                </p>
                                <p class="mt-3 text-primary"><a class="" href="/shop">Continuer mes achats</a></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>            
        </div>
    </div>
</section>

@include('include.footer')

<script src="{{ asset('js/secureCartManagement.js') }}"></script>