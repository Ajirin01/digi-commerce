
@php
    $carts = App\Models\Cart::with('product')->where("user_id", 1406)->get();
    $categories = App\Models\Category::with('products')->get();
@endphp

<!doctype html>
<html class="no-js" lang="zxx">


<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Digi-realm Ecommerce</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- CSS
	============================================ -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/font-awesome.css') }}">
    <!-- Fontawesome Star -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/fontawesome-stars.css') }}">
    <!-- Ion Icon -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/ion-fonts.css') }}">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/slick.css') }}">
    <!-- Animation -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.css') }}">
    <!-- jQuery Ui -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/jquery-ui.min.css') }}">
    <!-- Lightgallery -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/lightgallery.min.css') }}">
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/nice-select.css') }}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">

    <!-- Vendor & Plugins CSS (Please remove the comment from below vendor.min.css') }} & plugins.min.css') }} for better website load performance and remove css files from the above) -->
    <!--
    <script src="{{ asset('assets/js/vendor/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/plugins.min.js') }}"></script>
    -->

    <!-- Main Style CSS (Please use minify version for better website load performance) -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!--<link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">-->
    <script src="{{ asset('assets/js/angular.min.js') }}"></script>
</head>

<body ng-app="myApp" ng-controller="appController" class="template-color-1">

    <div class="main-wrapper">

        <!-- Begin Header Main Area -->
        <header class="header-main_area header-main_area-2 bg--black">
            <div class="header-middle_area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-3 col-lg-2 col-md-3 col-sm-5">
                            <div class="header-logo_area">
                                <a href="/">
                                    <img src="{{ asset('assets/images/menu/logo/1.png') }}" alt="Logo">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6 d-none d-lg-block">
                            <div class="hm-form_area">
                                <form action="{{ url('search-results') }}" method="GET" id="search-form2" class="hm-searchbox">
                                    <select class="nice-select select-search-category">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    <input type="text" name="query" placeholder="Enter your search key ...">
                                    <button class="header-search_btn" type="submit" onclick="document.getElementById('search-form2').submit()"><i
                                        class="ion-ios-search-strong"><span>Search</span></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-9 col-sm-7">
                            <div class="header-right_area">
                                <ul>
                                    <li class="mobile-menu_wrap d-flex d-lg-none">
                                        <a href="#mobileMenu" class="mobile-menu_btn toolbar-btn color--white">
                                            <i class="ion-navicon"></i>
                                        </a>
                                    </li>
                                    <li class="minicart-wrap">
                                        <a href="#miniCart" class="minicart-btn toolbar-btn">
                                            <div class="minicart-count_area">
                                                <span class="item-count">[[cart_total_items]]</span>
                                                <i class="ion-bag"></i>
                                            </div>
                                            <div class="minicart-front_text">
                                                <span>Cart:</span>
                                                <span class="total-price">&#x20A6;[[cart_sub_total]]</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="contact-us_wrap">
                                        <a href="tel://+234 703 699 8003"><i class="ion-android-call"></i>+234 703 699 8003</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-top_area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="custom-category_col col-12">
                            <div class="category-menu category-menu-hidden">
                                <div class="category-heading">
                                    <h2 class="categories-toggle">
                                        <span>Shop By</span>
                                        <span>Categories</span>
                                    </h2>
                                </div>
                                <div id="cate-toggle" class="category-menu-list">
                                    <ul>
                                        @foreach($categories as $category)
                                            @if ($category->parent == null)
                                                @if($category->children->count() > 0)
                                                    <li class="right-menu">
                                                @else
                                                <li>
                                                @endif
                                                    <a href="/category/{{$category->id}}/products?{{$category->name}}">{{ $category->name }}</a>
                                                    @if($category->children->count() > 0)
                                                        <ul class="cat-mega-menu">
                                                            @foreach($category->children as $child)
                                                                <li class="right-menu cat-mega-title">
                                                                    {{-- "/category/{{$category->id}}/products?{{$category->name}}" --}}
                                                                    {{-- <a href="{{ url('category/'.$child->id) }}">{{ $child->name }}</a> --}}
                                                                    <a href="/category/{{$child->id}}/products?{{$child->name}}">{{ $child->name }}</a>
                                                                    @if($child->children->count() > 0)
                                                                        <ul>
                                                                            @foreach($child->children as $subChild)
                                                                                <li><a href="/category/{{$subChild->id}}/products?{{$subChild->name}}">{{ $subChild->name }}</a></li>
                                                                                {{-- <li><a href="{{ url('category/'.$subChild->id) }}">{{ $subChild->name }}</a></li> --}}
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                        <div class="custom-menu_col col-12 d-none d-lg-block" style="margin-top: -50px">
                            <div class="main-menu_area position-relative">
                                <nav class="main-nav">
                                    <ul>
                                        <li><a href="/">Home</a></li>
                                        <li><a href="{{ URL::to('products') }}">Products</li>
                                        {{-- <li class=""><a href="{{ URL::to('about') }}">About Us</a></li> --}}
                                        <li class=""><a href="{{ URL::to('contact') }}">Contact</a></li>
                                        @auth
                                            <li class=""><a href="{{ URL::to('wish-list') }}">WishList</a></li>
                                        @endauth
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="custom-setting_col col-12 d-none d-lg-block">
                            <div class="ht-right_area">
                                <div class="ht-menu">
                                    <ul>
                                        <li><a href="{{ URL::to('account') }}">My Account<i class="fa fa-chevron-down"></i></a>
                                        <ul class="ht-dropdown ht-my_account">
                                            @auth
                                                {{-- <li><a href="{{ URL::to('account') }}"><span class="fa fa-user"></span> <span>My Account</span><i class="fa fa-chevron-down"></i></a> --}}

                                                <li class="active" ng-click="logout()"><a href="logout">logout</a></li>
                                            @endauth
                                            @guest
                                                <li class="active"><a href="{{ URL::to('login') }}">Login</a></li>
                                            @endguest
                                        </ul>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="custom-search_col d-none d-md-block d-lg-none">
                            <div class="hm-form_area">
                                <form action="{{ url('search-results') }}" class="hm-searchbox" action="GET" id="search-form">
                                    @csrf
                                    <select class="nice-select select-search-category" name="category_id">
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="query" placeholder="Enter your search key ...">
                                    <button class="header-search_btn" type="submit" onclick="document.getElementById('search-form').submit()"><i
                                        class="ion-ios-search-strong"><span>Search</span></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-top_area header-sticky bg--black">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-8 col-lg-7 d-lg-block d-none">
                            <div class="main-menu_area position-relative">
                                <nav class="main-nav">
                                    <ul>
                                        <li><a href="/">Home</a></li>
                                        <li><a href="{{ URL::to('products') }}">Products</li>
                                        {{-- <li class=""><a href="about-us.html">About Us</a></li> --}}
                                        <li class=""><a href="{{ URL::to('contact') }}">Contact</a></li>
                                        @auth
                                            <li class=""><a href="{{ URL::to('wish-list') }}">WishList</a></li>
                                        @endauth
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-sm-3 d-block d-lg-none">
                            <div class="header-logo_area header-sticky_logo">
                                <a href="/">
                                    <img src="{{ asset('assets/images/menu/logo/1.png') }}" alt="Logo">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-sm-9">
                            <div class="header-right_area">
                                <ul>
                                    <li class="mobile-menu_wrap d-flex d-lg-none">
                                        <a href="#mobileMenu" class="mobile-menu_btn toolbar-btn color--white">
                                            <i class="ion-navicon"></i>
                                        </a>
                                    </li>
                                    <li class="minicart-wrap">
                                        <a href="#miniCart" class="minicart-btn toolbar-btn">
                                            <div class="minicart-count_area">
                                                <span class="item-count">[[cart_total_items]]</span>
                                                <i class="ion-bag"></i>
                                            </div>
                                            <div class="minicart-front_text">
                                                <span>Cart:</span>
                                                <span class="total-price">&#x20A6;[[cart_sub_total]]</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="contact-us_wrap">
                                        <a href="tel://+234 703 699 8003"><i class="ion-android-call"></i>+234 703 699 8003</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas-minicart_wrapper" id="miniCart">
                <div class="offcanvas-menu-inner">
                    <a href="#" class="btn-close"><i class="ion-android-close"></i></a>
                    <div class="minicart-content">
                        <div class="minicart-heading">
                            <h4>Shopping Cart</h4>
                        </div>
                        <ul class="minicart-list">
                            <li ng-repeat="item in cart" class="minicart-product">
                                <a class="product-item_remove" href="javascript:void(0)" ng-click="removeFromCart(item.id)"><i
                                    class="ion-android-close"></i></a>
                                <div class="product-item_img">
                                    <img ng-src="[[getImageUrl(item.product)]]" alt="Product Image">
                                </div>
                                <div class="product-item_content">
                                    <a class="product-item_title" href="/product/[[getProductObject(item.product).id]]">[[getProductObject(item.product).name]]</a>
                                    <ul style="display: flex; justify-content: left">
                                        <li style="background-color: [[getCartItemVariations(item.variations).color]]; display: block; width: 20px; height: 20px; border-radius: 50px"></li>
                                        <li style="margin-left: 10px">
                                            [[getCartItemVariations(item.variations).size]]
                                        </li>
                                    </ul>
                                    {{-- <span style="background-color: [[getCartItemVariations(item.variations).color]]; display: block; width: 20px; height: 20px; border-radius: 50px"></span><span>[[getCartItemVariations(item.variations).size]]</span> --}}
                                    <span class="product-item_quantity">&#x20A6;[[item.quantity]] x [[item.price]] </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="minicart-item_total">
                        <span>Subtotal</span>
                        <span class="ammount">&#x20A6;[[cart_sub_total]]</span>
                    </div>
                    <div class="minicart-btn_area">
                        <a href="{{ url('cart')}}" class="uren-btn uren-btn_dark uren-btn_fullwidth">Manage Cart</a>
                    </div>
                    <div class="minicart-btn_area">
                        <a href="" ng-click="checkOutMiniCart()" class="uren-btn uren-btn_dark uren-btn_fullwidth">Checkout</a>
                    </div>
                </div>
            </div>
            <div class="mobile-menu_wrapper" id="mobileMenu">
                <div class="offcanvas-menu-inner">
                    <div class="container">
                        <a href="#" class="btn-close"><i class="ion-android-close"></i></a>
                        <div class="offcanvas-inner_search">
                            <form action="#" class="inner-searchbox">
                                <input type="text" placeholder="Search for item...">
                                <button class="search_btn" type="submit"><i class="ion-ios-search-strong"></i></button>
                            </form>
                        </div>
                        <nav class="offcanvas-navigation">
                            <ul class="mobile-menu">
                                <li><a href="/"><span
                                        class="mm-text">Home</span></a>
                                </li>
                                <li>
                                    <a href="{{ url('shop') }}">
                                        <span class="mm-text">Shop</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <nav class="offcanvas-navigation user-setting_area">
                            <ul class="mobile-menu">
                                <li class="menu-item-has-children active"><a href="javascript:void(0)"><span
                                        class="mm-text">Account</span></a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="my-account.html">
                                                <span class="mm-text">My Account</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="login-register.html">
                                                <span class="mm-text">Login | Register</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header Main Area End Here -->

        @yield('content')
        

        <!-- Begin Footer Area -->
        {{-- <div class="uren-footer_area">
            <div class="footer-top_area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="newsletter-area">
                                <h3 class="title">Join Our Newsletter Now</h3>
                                <p class="short-desc">Get E-mail updates about our latest shop and special offers.</p>
                                <div class="newsletter-form_wrap">
                                    <form action="http://devitems.us11.list-manage.com/subscribe/post?u=6bbb9b6f5827bd842d9640c82&amp;id=05d85f18ef" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="newsletters-form validate" target="_blank" novalidate>
                                        <div id="mc_embed_signup_scroll">
                                            <div id="mc-form" class="mc-form subscribe-form">
                                                <input id="mc-email" class="newsletter-input" type="email" autocomplete="off" placeholder="Enter your email" />
                                                <button class="newsletter-btn" id="mc-submit">Subscribe</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="footer-middle_area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="footer-widgets_info">
                                <div class="footer-widgets_logo">
                                    <a href="#">
                                        <img src="{{ asset('assets/images/menu/logo/1.png') }}" alt="Footer Logo">
                                    </a>
                                </div>
                                <div class="widget-short_desc">
                                    <p>Welcome to our ecommerce haven! Discover a shopping experience like no other – where ease, security,
                                         and speed converge. Shop with confidence, knowing that your transactions are seamless and your deliveries are swift.
                                    </p>
                                </div>
                                <div class="widgets-essential_stuff">
                                    <ul>
                                        <li class="uren-address"><span>Address:</span> Minna, Niger state, Nigeria.</li>
                                        <li class="uren-phone"><span>Call
                                        Us:</span> <a href="tel://+234 703 699 8003">+234 703 699 8003</a>
                                        </li>
                                        <li class="uren-email"><span>Email:</span> <a href="mailto://info@yourdomain.com">contact@ajirinibi.com.ng</a></li>
                                    </ul>
                                </div>
                                <div class="uren-social_link">
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
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="footer-widgets_area">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="footer-widgets_title">
                                            <h3>Information</h3>
                                        </div>
                                        <div class="footer-widgets">
                                            <ul>
                                                <li><a href="javascript:void(0)">About Us</a></li>
                                                <li><a href="javascript:void(0)">Delivery Information</a></li>
                                                <li><a href="javascript:void(0)">Privacy Policy</a></li>
                                                <li><a href="javascript:void(0)">Terms & Conditions</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="footer-widgets_title">
                                            <h3>Customer Service</h3>
                                        </div>
                                        <div class="footer-widgets">
                                            <ul>
                                                <li><a href="javascript:void(0)">Contact Us</a></li>
                                                <li><a href="javascript:void(0)">Returns</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="footer-widgets_title">
                                            <h3>My Account</h3>
                                        </div>
                                        <div class="footer-widgets">
                                            <ul>
                                                <li><a href="{{ URL::to('account') }}">My Account</a></li>
                                                <li><a href="{{ URL::to('account/orders') }}">Order History</a></li>
                                                <li><a href="{{ URL::to('wish-list') }}">Wish List</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom_area">
                <div class="container-fluid">
                    <div class="footer-bottom_nav">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="copyright">
                                    <span><a href="templateshub.net">Templateshub</a></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="payment">
                                    <a href="#">
                                        <img src="{{ asset('assets/images/footer/payment/1.png') }}" alt="Payment Method">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Area End Here -->

        <input type="hidden" name="variations" id="variations">
        <input type="hidden" name="" id="previousPrice">

        <!-- Begin Modal Area -->
        <div class="modal fade modal-wrapper" id="exampleModalCenter">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="modal-inner-area sp-area row">
                            <div class="col-lg-5">
                                <div class="sp-img_area">
                                    <div class="uren-slider_area uren-slider_area-2">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xl-9 col-lg-12">
                                                    <div class="main-slider slider-navigation_style-2">
                                                        <!-- Begin Single Slide Area -->
                                                        <div ng-repeat="photo in modalProductPhotos" class="single-slide animation-style-01" 
                                                        ng-style="{'background-image': 'url(' + photo + ')',
                                                        'background-repeat': 'no-repeat',
                                                        'background-position': 'center center',
                                                        'background-size': 'cover',
                                                        'min-height': '400px'}"
                                                        >
                                                            <div class="slider-content">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-6">
                                <div class="sp-content">
                                    <div class="sp-heading">
                                        <h5><a href="#" id="product_name">[[modalProduct.name]]</a></h5>
                                    </div>
                                    <div class="rating-box">
                                        <ul>
                                            <li ng-repeat="i in [0, 1, 2, 3, 4]" ng-if="i < rating"><i class="ion-android-star"></i></li>
                                            <li ng-repeat="i in [0, 1, 2, 3, 4]" ng-if="i >= rating" class="silver-color"><i class="ion-android-star"></i></li>
                                            {{-- <i class="ion-android-star" ng-class="{'silver-color': i >= rating}"></i> --}}
                                        </ul>
                                    </div>
                                    <div class="price-box">
                                        <span class="new-price new-price-2">&#x20A6;[[modalProduct.price]]</span>
                                        {{-- <span class="old-price">&#x20A6;[[modalProduct.price]]</span> --}}
                                    </div>
                                    <div class="sp-essential_stuff">
                                        <ul>
                                            {{-- <li>Brands <a href="javascript:void(0)">Buxton</a></li> --}}
                                            {{-- <li>Product Code: <a href="javascript:void(0)">Product 16</a></li> --}}
                                            {{-- <li>Reward Points: <a href="javascript:void(0)">100</a></li> --}}
                                            <li>Availability: <a href="javascript:void(0)">In Stock</a></li>
                                            <p>[[modalProduct.description]]</p>
                                            {{-- <li>EX Tax: <a href="javascript:void(0)"><span>$453.35</span></a></li>
                                            <li>Price in reward points: <a href="javascript:void(0)">400</a></li> --}}
                                        </ul>
                                    </div>
                                    {{-- <div class="color-list_area">
                                        <div class="color-list_heading">
                                            <h4>Available Options</h4>
                                        </div>
                                        <span class="sub-title">Color</span>
                                        <div class="color-list">
                                            <a href="javascript:void(0)" class="single-color active" data-swatch-color="red">
                                                <span class="bg-red_color"></span>
                                                <span class="color-text">Red (+$150)</span>
                                            </a>
                                            <a href="javascript:void(0)" class="single-color" data-swatch-color="orange">
                                                <span class="burnt-orange_color"></span>
                                                <span class="color-text">Orange (+$170)</span>
                                            </a>
                                            <a href="javascript:void(0)" class="single-color" data-swatch-color="brown">
                                                <span class="brown_color"></span>
                                                <span class="color-text">Brown (+$120)</span>
                                            </a>
                                            <a href="javascript:void(0)" class="single-color" data-swatch-color="umber">
                                                <span class="raw-umber_color"></span>
                                                <span class="color-text">Umber (+$125)</span>
                                            </a>
                                            <a href="javascript:void(0)" class="single-color" data-swatch-color="black">
                                                <span class="black_color"></span>
                                                <span class="color-text">Black (+$125)</span>
                                            </a>
                                            <a href="javascript:void(0)" class="single-color" data-swatch-color="golden">
                                                <span class="golden_color"></span>
                                                <span class="color-text">Golden (+$125)</span>
                                            </a>
                                        </div>
                                    </div> --}}
                                    <div class="quantity">
                                        <label>Quantity</label>
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box" value="1" type="text">
                                            <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                            <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                        </div>
                                    </div>
                                    <div class="uren-group_btn">
                                        <ul>
                                            <li><a href="cart.html" class="add-to_cart">Cart To Cart</a></li>
                                            <li><a href="cart.html"><i class="ion-android-favorite-outline"></i></a></li>
                                            <li><a href="cart.html"><i class="ion-ios-shuffle-strong"></i></a></li>
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
                                            <li class="youtube">
                                                <a href="https://www.youtube.com/" data-toggle="tooltip" target="_blank" title="Youtube">
                                                    <i class="fab fa-youtube"></i>
                                                </a>
                                            </li>
                                            <li class="google-plus">
                                                <a href="https://www.plus.google.com/discover" data-toggle="tooltip" target="_blank" title="Google Plus">
                                                    <i class="fab fa-google-plus"></i>
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

    </div>

    <!-- JS
============================================ -->

    <!-- jQuery JS -->
    <script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <!-- Modernizer JS -->
    <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <!-- Popper JS -->
    <script src="{{ asset('assets/js/vendor/popper.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>

    <!-- Slick Slider JS -->
    <script src="{{ asset('assets/js/plugins/slick.min.js') }}"></script>
    <!-- Barrating JS -->
    <script src="{{ asset('assets/js/plugins/jquery.barrating.min.js') }}"></script>
    <!-- Counterup JS -->
    <script src="{{ asset('assets/js/plugins/jquery.counterup.js') }}"></script>
    <!-- Nice Select JS -->
    <script src="{{ asset('assets/js/plugins/jquery.nice-select.js') }}"></script>
    <!-- Sticky Sidebar JS -->
    <script src="{{ asset('assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <!-- Jquery-ui JS -->
    <script src="{{ asset('assets/js/plugins/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.ui.touch-punch.min.js') }}"></script>
    <!-- Lightgallery JS -->
    <script src="{{ asset('assets/js/plugins/lightgallery.min.js') }}"></script>
    <!-- Scroll Top JS -->
    <script src="{{ asset('assets/js/plugins/scroll-top.js') }}"></script>
    <!-- Theia Sticky Sidebar JS -->
    <script src="{{ asset('assets/js/plugins/theia-sticky-sidebar.min.js') }}"></script>
    <!-- Waypoints JS -->
    <script src="{{ asset('assets/js/plugins/waypoints.min.js') }}"></script>
    <!-- jQuery Zoom JS -->
    <script src="{{ asset('assets/js/plugins/jquery.zoom.min.js') }}"></script>

    <!-- Vendor & Plugins JS (Please remove the comment from below vendor.min.js') }} & plugins.min.js') }} for better website load performance and remove js files from avobe) -->
    <!--
    <script src="{{ asset('assets/js/vendor/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/plugins.min.js') }}"></script>
    -->

    <!-- Main JS -->
    
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        var product_id
        var product_name
        var product_price
        var product_description
        var product_image
        var quantity
        

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });


        function selectedProduct(id, name, price, description, image, prescription){
            console.log(image)
            product_id = document.getElementById('product_id')
            product_name = document.getElementById('product_name')
            product_price = document.getElementById('product_price')
            product_description = document.getElementById('product_description')
            product_image = document.getElementById('product_image')

            product_id.value = id
            product_name.innerText = name
            product_price.innerText = price
            product_description.innerText = description
            product_image.src = image 
        }

        function restQuantity(){
            document.getElementById('quantity').value = 1
        }


    </script>

    <script src="{{ asset('assets/js/angular/ngStorage.js') }}"></script>
    <script src="{{ asset('assets/js/angular/pagination.js') }}"></script>
    <script src="{{ asset('assets/js/angular/query-object.js') }}"></script>

    <script src="{{ asset('assets/js/angular/myApp.js') }}"></script>
    <script src="{{ asset('assets/js/angular/appConfig.js') }}"></script>
    <script src="{{ asset('assets/js/angular/arrayAtIndex.js') }}"></script>
    <script src="{{ asset('assets/js/angular/number.js') }}"></script>
    <script src="{{ asset('assets/js/angular/parseJSON.js') }}"></script>
    <script src="{{ asset('assets/js/angular/stringifyJSON.js') }}"></script>
    <script src="{{ asset('assets/js/angular/setShippingCost.js') }}"></script>

    

    <script>
        myApp.filter('startFrom', function () {
            return function (input, start) {
                start = +start;
                return input.slice(start);
            };
        });
        

        myApp.controller("appController", function($scope, $scope, $sessionStorage, $http){
            $sessionStorage.checkout = []

            $scope.user = @json(Auth::user())

            console.log($scope.user)

            if($sessionStorage.cart == undefined){
                $sessionStorage.cart = [] 
            }

            if($scope.user == null){
                $scope.cart = $sessionStorage.cart

                $scope.cart_total_items = cart_total_items($scope.cart)
                $scope.cart_sub_total = cart_sub_total($scope.cart)
                
                // console.log("@@@@", )
            }else{
                $http.get("{{URL::to('api/carts/query?user_id=')}}"+$scope.user.id).
                then(res => {
                    $sessionStorage.cart = res.data
                    $scope.cart = $sessionStorage.cart

                    $scope.cart_total_items = cart_total_items($scope.cart)
                    $scope.cart_sub_total = cart_sub_total($scope.cart)
                    
                    console.log($scope.cart)

                    // console.log(res.data)

                    if (window.location.href.indexOf("/cart") > -1) {
                        console.log("Cart route detected");

                        $scope.searchText = '';
                        $scope.currentPage = 1;
                        $scope.pageSize = 5;

                        $scope.numberOfPages = function() {
                            return Math.ceil($scope.cart.length / $scope.pageSize);
                        };
                    }
                }).
                then(error => {
                    console.log(error)
                })
            }

            if(!(window.location == "{{URL::to('/')}}/checkout" || window.location == "{{URL::to('/')}}/cart")){
                $sessionStorage.checkout = []
                $sessionStorage.product = []
                $sessionStorage.checkout_sub_total = 0
            }

            console.log($sessionStorage.checkout)

            $scope.checkOutMiniCart = function(){
                event.preventDefault()
                var checkout = []
                $scope.cart.forEach((cart)=> {
                    checkout.push(cart)
                })
                $sessionStorage.checkout = checkout

                $scope.checkout = $sessionStorage.checkout

                $scope.checkout_total_items = cart_total_items($scope.checkout)
            
                $scope.checkout_sub_total = cart_sub_total($scope.checkout)

                $sessionStorage.checkout_sub_total = $scope.checkout_sub_total
                window.location = "{{ url('checkout') }}"
            }

            // console.log("{{Session::get('password_changed')}}")
            if("{{Session::get('password_changed')}}"){
                $sessionStorage.cart = []
            }

            $scope.getImageUrl = function(product) {
                // console.log("@@@@@@", product)
                // return
                try {
                    // Parse the JSON string to an array
                    const photoArray = JSON.parse(product.photos);
                    // console.log(photoArray)

                    // Assuming the first element in the array is the URL you want
                    return photoArray[0];
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    return ''; // Return a default URL or handle the error as needed
                }
            };

            $scope.getProductObject = function(product) {
                try {
                    // Parse the JSON string to an array
                    const productObject = product;

                    // Assuming the first element in the array is the URL you want
                    return productObject;
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    return ''; // Return a default URL or handle the error as needed
                }
            };

            $scope.getCartItemVariations = function(variations) {
                // console.log(variations)
                // return
                try {
                    // Parse the JSON string to an array
                    // const variation = JSON.parse(variations);
                    const variation = (variations);


                    // Assuming the first element in the array is the URL you want
                    return variation;
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    return ''; // Return a default URL or handle the error as needed
                }
            };

            $scope.selectedProduct = function(product, reviews){
                $scope.modalProduct = product
                $scope.modalProductReviews = reviews
                $scope.modalProductPhotos = JSON.parse(product.photos)
                // console.log($scope.modalProductPhotos)

                let total_reviews = $scope.modalProductReviews.length

                $scope.rating = 0;

                $scope.modalProductReviews.forEach(review=> {
                    $scope.rating += review.rating
                })

                if (total_reviews > 0) {
                    $scope.rating /= total_reviews;
                }
            }
            
            $scope.getAssetUrl = function(path) {
                return path;
            };

            if($sessionStorage.product == undefined){
                $sessionStorage.product = []
                $scope.product = $sessionStorage.product
            }else{
                $scope.product = $sessionStorage.product
                console.log($scope.product)
            }

            $scope.checkout = $sessionStorage.checkout
            

            $scope.checkout_sub_total = $sessionStorage.checkout_sub_total

            // console.log($sessionStorage.product)

            $scope.changeItemStatusInCart = function(cart, selected){
                // console.log(cart)
                console.log(selected)

                // $sessionStorage.product[cart.product_id] = selected
                
                $sessionStorage.product[cart.id] = selected
                // $scope.product = $sessionStorage.product
                // console.log($sessionStorage.product)


                // console.log("%%%%%%",$sessionStorage.product[cart.product_id])

                // console.log(selected)
                
                if($scope.checkout == undefined){
                    var checkout = []
                    checkout.push(cart)
                    $sessionStorage.checkout = checkout
                    
                }else{
                    var objectQuery = new ArrayQuery($sessionStorage.checkout)
                    // let getProduct = objectQuery.selectWhere({product_id: cart.product_id})
                    let getProduct = objectQuery.selectWhere({id: cart.id})

                    if(selected){
                        // console.log("hello")
                        if(getProduct.length < 1){ 
                            $sessionStorage.checkout.push(cart)
                            // console.log($sessionStorage.checkout)
                        }
                    }else{
                        let removeProduct = $scope.checkout.filter(cart_item=> {
                            // if(cart.product_id !== cart_item.product_id){
                            if(cart.id !== cart_item.id){
                                return cart_item
                            }
                        })

                        $sessionStorage.checkout = removeProduct
                    }
                }

                $scope.checkout = $sessionStorage.checkout

                $scope.checkout_total_items = cart_total_items($scope.checkout)
            
                $scope.checkout_sub_total = cart_sub_total($scope.checkout)

                $sessionStorage.checkout_sub_total = $scope.checkout_sub_total


                // console.log($sessionStorage.checkout)
            }

            // removed order items from cart starts
            $scope.orderItems = document.getElementById('orderItems')

            if($scope.orderItems != undefined){
                $scope.orderItems = $scope.orderItems.value

                // console.log($scope.orderItems)
                
                if($scope.orderItems != ""){
                    $scope.orderItems = JSON.parse($scope.orderItems)
                    // console.log("hhh", $scope.orderItems)

                    $scope.orderItems.forEach(orderItem=> {
                        let cart = $scope.cart.filter(cart_item => {
                            if(cart_item.id != orderItem.id){
                                return cart_item
                            }
                            // if(cart_item.product_id != id){
                            //     return cart_item
                            // }
                        })

                        $scope.cart = cart
                        $sessionStorage.cart = cart

                        $scope.cart_total_items = cart_total_items($scope.cart)
                        $scope.cart_sub_total = cart_sub_total($scope.cart)

                        $sessionStorage.checkout = []
                        $sessionStorage.product = []
                        $sessionStorage.checkout_sub_total = 0

                        $scope.checkout = []
                        $scope.product = []
                        $scope.checkout_sub_total = 0
                    })
                }

                
            }
            // removed order items from cart ends

            $scope.quantityChanged = function(id, quantity){
                var objectQuery = new ArrayQuery($sessionStorage.checkout)
                let product = objectQuery.selectWhere({product_id: id})

                if(product.length > 0){
                    product[0].product_quantity = quantity

                    $scope.checkout = $sessionStorage.checkout

                    $scope.checkout_sub_total = Math.ceil(cart_sub_total($scope.checkout))

                    $sessionStorage.checkout_sub_total = $scope.checkout_sub_total
                }
            }

            $scope.removeFromWishList = function(id){
                console.log(id)
                // return
                event.preventDefault()
                $http.delete("{{URL::to('api/wish-list')}}/"+id).
                then(res => {
                    // console.log(res.data)

                    Toast.fire({
                        icon: 'success',
                        title: 'Item sucessfully deleted from Wish list!'
                    })

                    window.location.reload()
                }).
                then(error => {
                    console.log(error)
                })
            }

            $scope.removeFromCart = function(id){
                // console.log(id)
                let remove = confirm("Are you sure you want to remove this item from your cart?")

                if(remove){
                    if($scope.user === null){
                        let cart = $scope.cart.filter(cart_item => {
                            if(cart_item.id != id){
                                return cart_item
                            }
                            // if(cart_item.product_id != id){
                            //     return cart_item
                            // }
                        })

                        $scope.cart = cart
                        $sessionStorage.cart = cart

                        $scope.cart_total_items = cart_total_items($scope.cart)
                        $scope.cart_sub_total = cart_sub_total($scope.cart)

                        Toast.fire({
                            icon: 'success',
                            title: 'Item sucessfully removed from cart!'
                        })

                        $sessionStorage.checkout = []
                        $sessionStorage.product = []
                        $sessionStorage.checkout_sub_total = 0

                        $scope.checkout = []
                        $scope.product = []
                        $scope.checkout_sub_total = 0

                    }else{
                        $http.delete("{{URL::to('api/carts')}}/"+id+ "?user_id="+ $scope.user.id).
                        then(res => {
                            console.log(res.data)
                            $sessionStorage.cart = res.data

                            $scope.cart = $sessionStorage.cart

                            $scope.cart_total_items = cart_total_items($scope.cart)
                        
                            $scope.cart_sub_total = cart_sub_total($scope.cart)

                            Toast.fire({
                                icon: 'success',
                                title: 'Item sucessfully deleted from cart!'
                            })
                        }).
                        then(error => {
                            console.log(error)
                        })
                    }
                }
            }
            
            $scope.submitReview = function(productId){
                // Get the element by its class name
                var element = document.querySelector('a.br-selected.br-current');

                // Get the value of the data-rating-value attribute
                var ratingValue = element.getAttribute('data-rating-value');

                // Log the value to the console or use it as needed
                console.log($scope.user);


                let review = {
                    rating: ratingValue,
                    review_text: $scope.review_text,
                    product_id: productId,
                    user_id: $scope.user.id
                }

                console.log(review)

                $http.post("{{URL::to('/api/product-reviews')}}", review).
                then(res => {
                    console.log(res)

                    Toast.fire({
                        icon: 'success',
                        title: 'Review sucessfully sumitted!'
                    })

                    window.location.reload()

                    // document.getElementById('closeModal').click()
                }).
                then(error => {
                    console.log(error)
                })
            }

            $scope.addToCart = function (productId){
                event.preventDefault()
                quantity = document.getElementById('quantity'+productId).value
                product_id = document.getElementById('product_id'+productId)
                product_price = document.getElementById('product_price'+productId)
                let product = JSON.parse(document.getElementById('product'+productId).value)
                let variations = document.getElementById('variations').value
                var user_id
                if($scope.user == null){
                    user_id = null
                }else{
                    user_id = $scope.user.id
                }

                var cart_obj = {
                        product_id: Number(product_id.value),
                        quantity: Number(quantity),
                        user_id,
                        product,
                        price: Number(parseInt(product_price.innerText.replace(/,/g, ''), 10)),
                        variations
                }

                console.log(cart_obj)

                // return

                if($scope.user == null){
                    // console.log("customer is not logged in")
                    function generateUniqueId() {
                        return 'id_' + Date.now().toString(36) + Math.random().toString(36).substr(2, 5);
                    }

                    cart_obj['id'] = generateUniqueId();

                    var cart = []

                    if($scope.cart == undefined){
                        cart.push(cart_obj)
                        $sessionStorage.cart = cart
                        
                    }else{
                        var objectQuery = new ArrayQuery($sessionStorage.cart)
                        let getProduct = objectQuery.selectWhere({product_id: Number(product_id.value)})
                        if(getProduct.length >= 1 && getProduct[0].variations == cart_obj.variations){
                            getProduct[0].quantity = getProduct[0].quantity + Number(quantity)
                            // console.log(getProduct[0].product_quantity)

                        }else{
                            $sessionStorage.cart.push(cart_obj)
                        }
                    }

                    $scope.cart = $sessionStorage.cart

                    $scope.cart_total_items = cart_total_items($scope.cart)
                
                    $scope.cart_sub_total = cart_sub_total($scope.cart)
                    
                    Toast.fire({
                        icon: 'success',
                        title: 'Item sucessfully added to cart!'
                    })

                    // document.getElementById('closeModal').click()
                    $('#closeModal').click()

                    console.log($sessionStorage.cart)
                }else{
                    // console.log("customer is logged in")
                    // return
                    $http.post("{{route('add-to-cart')}}", cart_obj).
                    then(res => {
                        // console.log("@@@@@",res.data)
                        // return 
                        $sessionStorage.cart = res.data

                        $scope.cart = $sessionStorage.cart

                        $scope.cart_total_items = cart_total_items($scope.cart)
                    
                        $scope.cart_sub_total = cart_sub_total($scope.cart)

                        Toast.fire({
                            icon: 'success',
                            title: 'Item sucessfully added to cart!'
                        })



                        document.getElementById('closeModal').click()
                    }).
                    then(error => {
                        console.log(error)
                    })

                }
                
            }

            $scope.addToWishList = function (product){
                event.preventDefault()
                // console.log(product)
                let wish_object = {
                    product_id: product.id,
                    user_id: @json(Auth::user()).id
                }

                $http.post("{{URL::to('/api/wish-list')}}", wish_object).
                    then(res => {
                        console.log(res.data)
                        Toast.fire({
                            icon: 'success',
                            title: 'Item sucessfully added to Wish list!'
                        })

                        document.getElementById('closeModal').click()
                    }).
                    then(error => {
                        console.log(error)
                    })

            }

            $scope.updateCart = function (){
                event.preventDefault()

                if($scope.user == null){
                    // console.log("customer is not logged in")
                    $scope.cart = $sessionStorage.cart

                    $scope.cart_total_items = cart_total_items($scope.cart)
                
                    $scope.cart_sub_total = cart_sub_total($scope.cart)
                    
                    Toast.fire({
                        icon: 'success',
                        title: 'Cart successfully updated!'
                    })

                    // document.getElementById('closeModal').click()
                    $('#closeModal').click()

                    console.log($sessionStorage.cart)
                }else{
                    // console.log("customer is logged in")
                    // return
                    $http.post("{{URL::to('/api/carts/update/all')}}", $sessionStorage.cart).
                    then(res => {
                        console.log(res.data)
                        
                        $sessionStorage.cart = res.data

                        $scope.cart = $sessionStorage.cart

                        $scope.cart_total_items = cart_total_items($scope.cart)
                    
                        $scope.cart_sub_total = cart_sub_total($scope.cart)

                        Toast.fire({
                            icon: 'success',
                            title: 'Cart successfully updated!'
                        })

                        // document.getElementById('closeModal').click()
                    }).
                    then(error => {
                        console.log(error)
                    })

                }
                
            }

            $scope.placeOrder = function(){
                // console.log($scope.checkout)
                let first_name = document.getElementById('first_name').value
                let last_name = document.getElementById('last_name').value
                let state = document.getElementById('state').value
                let city = document.getElementById('city').value
                let lga = document.getElementById('lga').value
                let address = document.getElementById('address').value
                let email = document.getElementById('email').value
                let selected_payment_method = document.getElementById('selected_payment_method').value

                

                let errors = []

                if(first_name === ""){
                    errors.push('First name can not be empty!')
                }
                if(last_name === ""){
                    errors.push('Last name can not be empty!')
                }
                if(state === ""){
                    errors.push('Please select state!')
                }
                if(city === ""){
                    errors.push('Enter select city!')
                }
                if(lga === ""){
                    errors.push('Please select local government area!')
                }
                if(address === ""){
                    errors.push('Address can not be empty!')
                }
                if(email === ""){
                    errors.push('Email can not be empty!')
                }
                if(selected_payment_method === ""){
                    errors.push('Please select payment method!')
                }

                if(errors.length > 0){
                    $scope.errors = errors
                }else{
                    document.getElementById('place_order_form').submit()

                }
            }

            $scope.logout = function(){
                event.preventDefault()
                $http.post("{{URL::to('/logout')}}").
                then(res => {
                    Toast.fire({
                        icon: 'success',
                        title: 'You have successfully logged out!'
                    })

                    $sessionStorage.cart = []

                    setTimeout(() => {
                        window.location = "{{URL::to('/')}}"
                    }, 2000);
                    
                })
            },

            $scope.removeAddress = function(id){
                console.log(id)
                // return
                event.preventDefault()
                let confirmRemove = confirm("Are you sure you want to remove this address?")

                if(confirmRemove){

                
                    $http.delete("{{URL::to('api/shipping/delete-address')}}/"+id).
                    then(res => {
                        // console.log(res.data)
                        Toast.fire({
                            icon: 'success',
                            title: 'Address sucessfully removed!'
                        })

                        window.location.reload()
                    }).
                    then(error => {
                        console.log(error)
                    })
                }
            }

            if (
                window.location.href === "{{URL::to('/')}}/checkout" ||
                window.location.href === "{{URL::to('/')}}/account/add-address" ||
                window.location.href.startsWith("{{URL::to('/')}}/account/address")
            ){
                $http.get("{{URL::to('/')}}/nigeria-state-and-lgas.json").
                then(res => {
                    console.log(res.data)
                    $scope.statesAndLgas = res.data
                }).
                then(error =>{
                    console.log(error)
                })
            }


            
        })

        function cart_total_items(cart){
            let items = 0
            if(cart !== undefined){
                for (let count = 0; count < cart.length; count++) {
                    items++
                }
            }

            return items
        }

        function cart_sub_total(cart){
            let sub_total = 0
            if(cart !== undefined){
                for (let count = 0; count < cart.length; count++) {
                    sub_total = sub_total + (cart[count].price * cart[count].quantity)
                }
            }

            return Math.ceil(sub_total)
        }
    </script>

    <script>
        var colorPrice = 0
        var sizePrice = 0
        var variations = {}
        var price = colorPrice + sizePrice
        
        function updatePrice(productId, productPrice, variationValue, variationType) {
            // console.log(variationValue)
            // return
            var priceArea = document.getElementById('product_price' + productId);
            var previousAddedPriceInput = document.getElementById('previousPrice');

            // Remove commas and parse the old price
            let oldPrice = parseInt(priceArea.innerText.replace(/,/g, ''), 10);
            var previousAddedPrice = Number(previousAddedPriceInput.value) ?? 0;

            // Check if the previous variation was color or size
            var previousVariationType = previousAddedPriceInput.getAttribute('data-variation-type');
            
            // Calculate the new price based on the variation type
            var newPrice;
            if (variationType === 'color') {
                colorPrice = Number(variationValue[0])

                newPrice = colorPrice + sizePrice + Number(productPrice);
                variations['color'] = variationValue[1]
            } else if (variationType === 'size') {
                sizePrice = JSON.parse(event.target.getAttribute('data-value'))[0]

                newPrice = colorPrice + sizePrice + Number(productPrice);
                variations['size'] = JSON.parse(event.target.getAttribute('data-value'))[1]
            }

            document.getElementById('variations').value = JSON.stringify(variations)

            // Format the new price with commas
            let formattedNewPrice = newPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            // Update the price area with the formatted new price
            priceArea.innerText = formattedNewPrice;

            // Update the previous added price input and its data attribute
            previousAddedPriceInput.value = variationValue;
            previousAddedPriceInput.setAttribute('data-variation-type', variationType);
        }
    </script>

</body>


</html>