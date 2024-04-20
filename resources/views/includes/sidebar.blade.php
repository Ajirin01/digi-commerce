@php
    $categories = App\Models\Category::with('products')->get();
    $shops = App\Models\Shop::with('products')->inRandomOrder()->limit(10)->get();
    $brands = App\Models\Brand::with('products')->inRandomOrder()->limit(10)->get();

    $min_price_product = App\Models\Product::whereNotNull('price')->orderBy('price')->first();
    $max_price_product = App\Models\Product::whereNotNull('price')->orderBy('price', 'desc')->first();

    $min_price = $min_price_product ? $min_price_product->price : 0;
    $max_price = $max_price_product ? $max_price_product->price : 0;

@endphp

<div class="col-lg-3 col-md-5 order-2 order-lg-1 order-md-1">
    <div class="uren-sidebar-catagories_area">
        <div class="category-module uren-sidebar_categories">
            <div class="category-module_heading">
                <h5>Categories</h5>
            </div>
            <div class="module-body">
                <ul class="module-list_item">
                    <li>
                        @foreach ($categories as $category)
                            @if ($category->products->count() > 0)
                                <a href="{{ URL::to('/category/'. $category->id. '/products?'.$category->name) }}">{{$category->name}} <span>({{$category->products->count()}})</span></a>
                            @endif
                        @endforeach
                        <a class="active" href="javascript:void(0)">Shop <span>({{$shops->count()}})</span></a>
                        <ul class="module-sub-list_item">
                            <li>
                                @foreach ($shops as $shop)
                                    @if ($shop->products->count() > 0)
                                        <a href="{{ URL::to('/shop/'. $shop->id. '/products?s='.$shop->name) }}">{{$shop->name}} <span>({{$shop->products->count()}})</span></a>
                                    @endif
                                @endforeach
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="uren-sidebar_categories">
            <div class="uren-categories_title">
                <h5>Price</h5>
            </div>
            <div class="price-filter">
                <div id="slider-range"></div>
                <div class="price-slider-amount">
                    <div class="label-input" style="width: 300px">
                        <form action="{{ url('products-filtered') }}" method="get">
                            <label>price : </label>
                            <input type="hidden" name="" id="min_price" value="{{$min_price}}">
                            <input type="hidden" name="" id="max_price" value="{{$max_price}}">
                            <input type="text" id="amount" name="price" placeholder="Add Your Price" disabled/>
                            <input type="submit" class="uren-login_btn" value="Apply"/>
                        </form>
                    </div>
                    <!-- <button type="button">Filter</button> -->
                </div>
            </div>
        </div>
        <div class="uren-sidebar_categories">
            <div class="uren-categories_title">
                <h5>Manufacturers</h5>
            </div>
            <ul class="sidebar-checkbox_list">
                @foreach ($brands as $brand)
                    <li>
                        @if ($brand->products->count() > 0)
                            <a href="{{ URL::to('/brand/'. $brand->id. '/products?'. $brand->name) }}">{{$brand->name}} <span>({{$brand->products->count()}})</span></a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="sidebar-banner_area">
        <div class="banner-item img-hover_effect">
            <a href="javascript:void(0)">
                <img src="assets/images/shop/1.jpg" alt="Uren's Shop Banner Image">
            </a>
        </div>
    </div>
</div>