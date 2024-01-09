<!-- Begin Modal Area -->
<div class="modal fade modal-wrapper" id="exampleModalCenter{{$product->id}}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-inner-area sp-area row">
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
</div>
<!-- Modal Area End Here -->