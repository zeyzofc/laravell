@extends('front.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>
                    
            <div class="card">
                <div class="card-body">
                    <div class="accordion accordion-flush" id="accordionExample">

                        @if ($categories->isNotEmpty())
                            
                        @foreach ( $categories as $key => $category)
                            
                        <div class="accordion-item">
                            @if ($category->sub_category->isNotEmpty())
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#collapseOne-{{ $key }}" aria-expanded="false" aria-controls="collapseOne-{{ $key }}">
                                    {{ $category->name }}
                                </button>
                            </h2>

                            @else
                            <a href="{{ route("front.shop", $category->slug ) }}" class="nav-item nav-link {{ ($categorySelected == $category->id) ? 'text-primary' : '' }}">{{ $category->name }}</a>
                            @endif

                            @if ($category->sub_category->isNotEmpty())
                            <div id="collapseOne-{{ $key }}" class="accordion-collapse collapse {{ ($categorySelected == $category->id) ? 'show' : '' }}" aria-labelledby="headingOne" 
                            data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="navbar-nav">
                                        @foreach ($category->sub_category as $subCategory )
                                            <a href="{{ route("front.shop", [$category->slug,$subCategory->slug]) }}" class="nav-item nav-link {{ ($subCategorySelected == $subCategory->id) ? 'text-primary' : '' }}">{{ $subCategory->name }}</a>
                                        @endforeach
                                                                            
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        @endforeach

                        @endif
                                            
                    </div>
                </div>
            </div>

                    <div class="sub-title mt-5">
                        <h2>Brand</h3>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            @if ($brands->isNotEmpty())
                            @foreach ($brands as $brand)
                                
                            
                            <div class="form-check mb-2">
                                <input {{ (in_array($brand->id, $brandsArray)) ? 'checked' : '' }} class="form-check-input brand-label" type="checkbox" name="brand[]" value="{{ $brand->id }}" id="brand-{{ $brand->id }}">
                                <label class="form-check-label" for="brand-{{ $brand->id }}">
                                    {{ $brand->name }}
                                </label>
                            </div>
                            @endforeach
                            @endif

                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Price</h3>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <input type="text" class="js-range-slider" name="my_range" value="" />
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    {{-- <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">Sorting</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Latest</a>
                                            <a class="dropdown-item" href="#">Price High</a>
                                            <a class="dropdown-item" href="#">Price Low</a>
                                        </div>
                                    </div> --}}

                                    <select name="sort" id="sort" class="form-control">
                                        <option value="latest" {{ ($sort == 'latest') ? 'selected' : '' }}>Latest</option>
                                        <option value="price_desc" {{ ($sort == 'price_desc') ? 'selected' : '' }}>Highest Price</option>
                                        <option value="price_asc" {{ ($sort == 'price_asc') ? 'selected' : '' }}>Lowest Price</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                         @if ($products->isNotEmpty())
                            @foreach ($products as $product)
                            @php
                                $productImage = $product->product_images->first();
                            @endphp
                        <div class="col-md-4">
                            <div class="card product-card">
                                <div class="product-image position-relative">

                                    <a href="{{ route("front.product",$product->slug) }}" class="product-img">
                                    @if (!empty($productImage->image))
                                        <img class="card-img-top" src="{{ asset('uploads/product/small/'.$productImage->image) }}"/>
                                    @else
                                        <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}"/>
                                    @endif
                                    </a>

                                    <a onclick="addToWishlist({{ $product->id }})" class="whishlist" href="javascript:void(0);"><i class="far fa-heart"></i></a>

                                    <div class="product-action">
                                        @if ($product->track_qty == 'Yes')
                                            @if ($product->qty > 0)
                                                <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                                </a>
                                        @else
                                        <a class="btn btn-dark" href="javascript:void(0);" onclick="showOutOfStockAlert();">
                                            Kehabisan Stock
                                        </a>
                                        @endif
                                        @else
                                        <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="{{ route("front.product",$product->slug) }}">{{ $product->title }}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>Rp {{ number_format($product->price,2) }}</strong></span>

                                        @if ($product->compare_price > 0)
                                        <span class="h6 text-underline"><del>Rp {{ number_format($product->compare_price,2) }}</del></span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                        @endif
                        
                        <div class="col-md-12 pt-5">
                            {{ $products->withQueryString()->links() }}
                            {{-- <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>

        rangeSlider = $(".js-range-slider").ionRangeSlider({
           type : "double",
           min : 0,
           max : 1000000,
           from : {{ ($priceMin) }},
           step : 100000,
           to: {{ ($priceMax) }},
           skin : "round",
           max_postfix: "+",
           prefix: "Rp ",
           onFinish: function(){
            apply_filters()
           }
        });

        var slider = $(".js-range-slider").data("ionRangeSlider");


        $(".brand-label").change(function(){
            apply_filters();
        });

        $("#sort").change(function(){
            apply_filters();
        });

        function apply_filters(){
            var brand = [];

            $(".brand-label").each(function(){
                if ($(this).is(":checked") == true) {
                    brand.push($(this).val());
                }
            });

            //console.log(brand.toString());

            var url = '{{ url()->current() }}?';

            // Brand Filter
            if (brand.length > 0) {
                url += '&brand='+brand.toString();
            }

            //Price Slider
            url += '&price_min='+slider.result.from+'&price_max='+slider.result.to;

            // Search
            var keyword = $("#search").val();

            if(keyword.length > 0) {
                url += '&search='+keyword;

            }
            
            //Sorting Product
            url += '&sort='+$("#sort").val()

            window.location.href = url;
        }
    </script>

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