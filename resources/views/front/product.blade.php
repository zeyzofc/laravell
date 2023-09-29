@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop') }}">Shop</a></li>
                <li class="breadcrumb-item">{{ $product->title }}</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-7 pt-3 mb-3">
    <div class="container">
        <div class="row ">
            <div class="col-md-5">
                <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner bg-light">

                        @if ($product->product_images)
                            @foreach ($product->product_images as $key=> $productImage)
                            <div class="carousel-item {{ ($key == 0) ? 'active' : '' }}">
                                <img class="w-100 h-100" src="{{ asset('uploads/product/large/'. $productImage->image) }}" alt="">
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-7">
                <div class="bg-light right">
                    <h1>{{ $product->title }}</h1>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div>
                        <small class="pt-1">(99 Reviews)</small>
                    </div>
                        @if ($product->compare_price > 0)
                        <h2 class="price text-secondary"><del>Rp {{ number_format($product->compare_price,2) }}</del></h2>
                        @endif
                        
                        <h2 class="price ">Rp {{ number_format($product->price,2) }}</h2>

                        {!! $product->short_description !!}

                        <br>
                        {{-- <a href="javascript:void(0);" onclick="addToCart({{ $product->id }});" class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a> --}}

                        @if ($product->track_qty == 'Yes')
                                    @if ($product->qty > 0)
                                        <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                                            <i class="fa fa-shopping-cart"></i> &nbsp;Add To Cart
                                        </a>
                                @else
                                    <a class="btn btn-dark" href="javascript:void(0);" onclick="showOutOfStockAlert();">
                                        Kehabisan Stock
                                    </a>
                                @endif
                                @else
                                <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                                    <i class="fa fa-shopping-cart"></i> &nbsp;Add To Cart
                                </a>
                                @endif
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <div class="bg-light">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping & Returns</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            {!! $product->description !!}
                        </div>
                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                            {!! $product->shipping_returns !!}
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if (!empty($relatedProducts))
<section class="pt-5 section-8">
    <div class="container">
        <div class="section-title">
            <h2>Related Products</h2>
        </div>
        <div class="col-md-12">
            <div id="related-products" class="carousel">

                @foreach ($relatedProducts as $relProduct)
                @php
                    $productImage = $relProduct->product_images->first();
                @endphp
                <div class="card product-card">
                    <div class="product-image position-relative">
                        
                        
                        
                        <a href="{{ route("front.product",$relProduct->slug) }}" class="product-img">
                            {{-- <img class="card-img-top" src="images/product-1.jpg" alt=""> --}}
                            @if (!empty($productImage->image))
                            <img class="card-img-top"  src="{{ asset('uploads/product/small/'.$productImage->image) }}"/>
                            @else
                            <img src="{{ asset('admin-assets/img/default-150x150.png') }}"/>
                            @endif
                        </a>


                       <a onclick="addToWishlist({{ $product->id }})" class="whishlist" href="javascript:void(0);"><i class="far fa-heart"></i></a>
                        <div class="product-action">
                            {{-- <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                                <i class="fa fa-shopping-cart"></i> Add To Cart
                            </a> --}}

                            <div class="product-action">
                                @if ($relProduct->track_qty == 'Yes')
                                    @if ($relProduct->qty > 0)
                                        <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $relProduct->id }});">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>
                                @else
                                    <a class="btn btn-dark" href="javascript:void(0);" onclick="showOutOfStockAlert();">
                                        Kehabisan Stock
                                    </a>
                                @endif
                                @else
                                <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $relProduct->id }});">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center mt-3">
                        <a class="h6 link" href="{{ route("front.product",$relProduct->slug) }}">{{ $relProduct->title }}</a>
                        <div class="price mt-2">
                            <span class="h5"><strong>Rp{{ $relProduct->price }}</strong></span>
                            @if ($relProduct->compare_price > 0)
                            <span class="h6 text-underline"><del>Rp{{ $relProduct->compare_price }}</del></span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
               
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@section('customJs')
    <script>
    function showOutOfStockAlert() {
        Swal.fire({
            icon: 'error',
            title: 'Out of Stock',
            text: 'Sorry, this product is currently out of stock.',
            confirmButtonText: 'OK'
        });
    }

    function addToCart(id) {
    $.ajax({
        url: '{{ route("front.addToCart") }}',
        type: 'post',
        data: { id: id },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status == true) {
                // Product added to the cart successfully, show a SweetAlert2 success popup
                Swal.fire({
                    icon: 'success',
                    title: 'Added to Cart ',
                    html: response.message,
                    showConfirmButton: false, // Remove the "OK" button
                    timer: 1500 // Auto close after 1.5 seconds
                });
                // You can also redirect to the cart page if needed
                // window.location.href = '{{ route("front.cart") }}';
            } else {
                // Product is already added to the cart, show a SweetAlert2 info popup
                Swal.fire({
                    icon: 'info',
                    title: 'Product Already in Cart',
                    html: response.message,
                    confirmButtonText: 'OK',
                    footer: '<a href="{{ route('front.cart') }}">Go to Cart</a>'
                });
            }
        }
    });
}

function addToWishlist(id) {
    $.ajax({
        url: '{{ route("front.addToWishlist") }}',
        type: 'post',
        data: { id: id },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status == true) {
                // Product added to the wishlist successfully, show a SweetAlert2 success popup
                Swal.fire({
                    icon: 'success',
                    title: 'Added to Wishlist',
                    html: response.message,
                    showConfirmButton: false, // Remove the "OK" button
                    timer: 1500 // Auto close after 1.5 seconds
                });
            } else {
                // Product is already in the wishlist, show a SweetAlert2 info popup
                Swal.fire({
                    icon: 'info',
                    title: 'Product Already in Wishlist',
                    html: response.message,
                    confirmButtonText: 'OK',
                    footer: '<a href="{{ route('account.wishlist') }}">Go to Wishlist</a>'
                });
            }
        }
    });
}

</script>
@endsection