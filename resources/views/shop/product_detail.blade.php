@extends('layouts.shop_layout')
@section('content')
    <!-- Begin Breadcrumb Area -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <h2>Product Information</h2>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li class="active">{{$product->name}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End Here -->

    <!-- Begin Single Product Sale Area -->
    <div class="sp-area">
        <div class="container-fluid">
            <div class="sp-nav">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="sp-img_area">
                            <div class="sp-img_slider slick-img-slider uren-slick-slider" data-slick-options='{
                            "slidesToShow": 1,
                            "arrows": false,
                            "fade": true,
                            "draggable": false,
                            "swipe": false,
                            "asNavFor": ".sp-img_slider-nav"
                            }'>
                                @foreach ((json_decode($product->photos)) as $photo)
                                    <div class="single-slide red zoom">
                                        <img src="{{$photo}}" alt="Product Image">
                                    </div>
                                @endforeach
                                
                            </div>
                            <div class="sp-img_slider-nav slick-slider-nav uren-slick-slider slider-navigation_style-3" data-slick-options='{
                                    "slidesToShow": 3,
                                    "asNavFor": ".sp-img_slider",
                                    "focusOnSelect": true,
                                    "arrows" : true,
                                    "spaceBetween": 30
                                }' data-slick-responsive='[
                                        {"breakpoint":1501, "settings": {"slidesToShow": 3}},
                                        {"breakpoint":992, "settings": {"slidesToShow": 4}},
                                        {"breakpoint":768, "settings": {"slidesToShow": 3}},
                                        {"breakpoint":575, "settings": {"slidesToShow": 2}}
                                    ]'>
                                @foreach ((json_decode($product->photos)) as $photo)
                                    <div class="single-slide red">
                                        <img src="{{$photo}}" alt="Product Thumnail">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="sp-content">
                            <div class="sp-heading">
                                <h5><a href="/product/{{$product->id}}">{{$product->name}}</a></h5>
                            </div>
                            <div class="rating-box">
                                @include('includes.rating')
                            </div>
                            <div class="sp-essential_stuff">
                                <ul>
                                    <li>Brands: <a href="/brand/{{$product->brand->id}}/products?{{$product->brand->name}}">{{$product->brand->name}}</a></li>
                                    @if ($product->sold < $product->quantity)
                                        <li>Availability: <a href="javascript:void(0)">In Stock</a></li>
                                    @else
                                        <li>Availability: <a href="javascript:void(0)">Out of Stock</a></li>
                                    @endif
                                    <li>Price: <span class="new-price new-price-2">&#x20A6;</span><span class="new-price new-price-2" id="product_price{{$product->id}}">{{ number_format($product->price, 0, ',', ',') }}</span></li>

                                </ul>
                            </div>
                            <div class="color-list_area">
                                <div class="color-list_heading">
                                    <h4>Available Options</h4>
                                </div>
                                <span class="sub-title">Color</span>
                                <div class="color-list">
                                    @foreach (optional(json_decode($product->variations))->colors ?? [] as $colorCode => $price)
                                        <a href="javascript:void(0)" class="single-color active" data-swatch-color="red">
                                            <span style="background-color: {{$colorCode}}; display: block;" onclick="updatePrice({{$product->id}}, {{$product->price}}, [{{$price}}, '{{$colorCode}}'], 'color')"></span>
                                            <span class="color-text"> +(&#x20A6;<span>{{$price}})</span> </span>
                                        </a>
                                    @endforeach
                                </div>

                                <div class="product-size_box">
                                    <span>Size</span>
                                    <select class="myniceselect nice-select" onchange="updatePrice({{$product->id}}, {{$product->price}}, this.value, 'size')">
                                        @foreach (optional(json_decode($product->variations))->sizes?? [] as $sizeCode => $price)
                                            <option value='[{{$price}}, "{{$sizeCode}}"]'>{{$sizeCode}} +(&#x20A6;{{$price}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="countdown-wrap">
                                <div class="countdown item-4" data-countdown="2020/10/01" data-format="short">
                                    <div class="countdown__item">
                                        <span class="countdown__time daysLeft"></span>
                                        <span class="countdown__text daysText"></span>
                                    </div>
                                    <div class="countdown__item">
                                        <span class="countdown__time hoursLeft"></span>
                                        <span class="countdown__text hoursText"></span>
                                    </div>
                                    <div class="countdown__item">
                                        <span class="countdown__time minsLeft"></span>
                                        <span class="countdown__text minsText"></span>
                                    </div>
                                    <div class="countdown__item">
                                        <span class="countdown__time secsLeft"></span>
                                        <span class="countdown__text secsText"></span>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="quantity">
                                {{-- <form action="" id="add-to-cart-form"> --}}
                                    <label>Quantity</label>
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" name="quantity" id="quantity{{$product->id}}" value="1" type="text">
                                        <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                        <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                    </div>
                                    <input type="hidden" name="product_id" id="product_id{{$product->id}}" value="{{$product->id}}">
                                    <input type="hidden" name="product" id="product{{$product->id}}" value="{{$product}}">
                                    @auth
                                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    @endauth
                                    @guest
                                        <input type="hidden" name="user_id" value="">
                                    @endguest
                                {{-- </form> --}}
                            </div>
                            <div class="qty-btn_area">
                                <ul>
                                    <li><a class="qty-cart_btn" href="" ng-click="addToCart({{$product->id}})">Add To Cart</a></li>
                                    {{-- <li><a class="qty-wishlist_btn" href="wishlist.html" data-toggle="tooltip" title="Add To Wishlist"><i class="ion-android-favorite-outline"></i></a></li> --}}
                                    @auth
                                        <li><a class="uren-wishlist" href="wishlist" data-toggle="tooltip" data-placement="top" title="Add To Wishlist" ng-click="addToWishList({{$product}})"><i
                                            class="ion-android-favorite-outline"></i></a>
                                        </li>
                                    @endauth
                                    {{-- <li><a class="qty-compare_btn" href="compare.html" data-toggle="tooltip" title="Compare This Product"><i class="ion-ios-shuffle-strong"></i></a></li> --}}
                                </ul>
                            </div>
                            {{-- <div class="uren-social_link">
                                <ul>
                                    <li class="facebook">
                                        <a href="https://www.facebook.com/" data-toggle="tooltip" target="_blank" title="Facebook">
                                            <i class="fab fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li class="twitter">
                                        <a href="https://twitter.com/" data-toggle="tooltip" target="_blank" title="Twitter">
                                            <i class="fab fa-twitter-square"></i>
                                        </a>
                                    </li>
                                    <li class="instagram">
                                        <a href="https://rss.com/" data-toggle="tooltip" target="_blank" title="Instagram">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product Sale Area End Here -->

    <!-- Begin Single Product Tab Area -->
    <div class="sp-product-tab_area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sp-product-tab_nav">
                        <div class="product-tab">
                            <ul class="nav product-menu">
                                <li><a class="active" data-toggle="tab" href="#description"><span>Description</span></a>
                                </li>
                                <li><a data-toggle="tab" href="#reviews"><span>Reviews ({{$product->reviews->count()}})</span></a></li>
                            </ul>
                        </div>
                        <div class="tab-content uren-tab_content">
                            <div id="description" class="tab-pane active show" role="tabpanel">
                                <div class="product-description">
                                    {!! $product->description !!}
                                </div>
                            </div>
                            <div id="reviews" class="tab-pane" role="tabpanel">
                                <div class="tab-pane active" id="tab-review">
                                    <form class="form-horizontal" id="form-review">
                                        <div id="review">
                                            <table class="table table-striped table-bordered">
                                                <tbody>
                                                    @foreach ($product->reviews as $review)
                                                    <tr>
                                                        <td style="width: 50%;"><strong>{{$review->user->name}}</strong></td>
                                                        <td class="text-right">{{$review->created_at}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            {{-- @foreach ($product->reviews as $review) --}}
                                                            <p>{{$review->review_text}}</p>
                                                            <div class="rating-box">
                                                                <ul>
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        @if ($i < $review->rating)
                                                                            <li><i class="ion-android-star"></i></li>
                                                                        @else
                                                                            <li class="silver-color"><i class="ion-android-star"></i></li>
                                                                        @endif
                                                                    @endfor
                                                                </ul>
                                                                {{-- @include('includes.rating') --}}
                                                            </div>
                                                            {{-- @endforeach --}}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @auth
                                            <h2>Write a review</h2>
                                            <div class="form-group required second-child">
                                                <div class="col-sm-12 p-0">
                                                    <label class="control-label">Share your opinion</label>
                                                    <textarea class="review-textarea" ng-model="review_text" name="con_message" id="con_message"></textarea>
                                                    <div class="help-block"><span class="text-danger">Note:</span> HTML is not
                                                        translated!</div>
                                                </div>
                                            </div>
                                            <div class="form-group last-child required">
                                                <div class="col-sm-12 p-0">
                                                    <div class="your-opinion">
                                                        <label>Your Rating</label>
                                                        <span>
                                                    <select ng-model="review_rating" class="star-rating">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="uren-btn-ps_right">
                                                    <button class="uren-btn-2" ng-click="submitReview({{$product->id}})">Continue</button>
                                                </div>
                                            @endauth
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product Tab Area End Here -->

    
    <!-- Begin Product Area -->
    <div class="uren-product_area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title_area">
                        <span></span>
                        <h3>Related Products</h3>
                    </div>
                    <div class="product-slider uren-slick-slider slider-navigation_style-1 img-hover-effect_area" data-slick-options='{
                    "slidesToShow": 6,
                    "arrows" : true
                    }' data-slick-responsive='[
                                            {"breakpoint":1501, "settings": {"slidesToShow": 4}},
                                            {"breakpoint":1200, "settings": {"slidesToShow": 3}},
                                            {"breakpoint":992, "settings": {"slidesToShow": 2}},
                                            {"breakpoint":767, "settings": {"slidesToShow": 1}},
                                            {"breakpoint":480, "settings": {"slidesToShow": 1}}
                                        ]'>
                        @foreach ($relatedProducts as $product)
                            <div class="product-slide_item">
                                <div class="inner-slide">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="/product/{{$product->id}}">
                                                <img class="primary-img" src="{{(json_decode($product->photos))[0]}}" alt="Product Image">
                                                <img class="secondary-img" src="{{(json_decode($product->photos))[1]}}" alt="Product Image">
                                            </a>
                                            @if ($product->sale_type == "new_arrival")
                                                <div class="sticker">
                                                    <span class="sticker">New</span>
                                                </div>
                                            @endif
                                            
                                            @if ($product->sale_type == "hot_sale")
                                                <div class="sticker-area-2">
                                                    <span class="sticker-2">-20%</span>
                                                    <span class="sticker">Sale</span>
                                                </div>
                                            @endif
            
                                            @if ($product->sale_type == "featured")
                                                <div class="sticker" style="width: 60px !important;">
                                                    <span class="sticker-2" >Featured</span>
                                                </div>
                                            @endif
                                            
                                            
                                            <div class="add-actions">
                                                <ul>
                                                    <li><a class="uren-add_cart" href="/product/{{$product->id}}" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i
                                                        class="ion-bag"></i></a>
                                                    </li>
                                                    @auth
                                                        <li><a class="uren-wishlist" href="wishlist" data-toggle="tooltip" data-placement="top" title="Add To Wishlist" ng-click="addToWishList({{$product}})"><i
                                                            class="ion-android-favorite-outline"></i></a>
                                                        </li>
                                                    @endauth
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-desc_info">
                                                <div class="rating-box">
                                                    @include('includes.rating')
                                                </div>
                                                <h6><a class="product-name" href="/product/{{$product->id}}">{{$product->name}}</a></h6>
                                                <div class="price-box">
                                                    <span class="new-price">&#x20A6;{{$product->price}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Area End Here -->
    
    <!-- Shop Left Sidebar Area End Here -->
    @include('includes.footer_brands')
@endsection