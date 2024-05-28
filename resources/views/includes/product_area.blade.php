<div class="col-lg-9 col-md-7 order-1 order-lg-2 order-md-2">
    <div class="shop-toolbar">
        <div class="product-view-mode">
            <a class="grid-1" data-target="gridview-1" data-toggle="tooltip" data-placement="top" title="1">1</a>
            <a class="grid-2" data-target="gridview-2" data-toggle="tooltip" data-placement="top" title="2">2</a>
            <a class="active grid-3" data-target="gridview-3" data-toggle="tooltip" data-placement="top" title="3">3</a>
            <a class="grid-4" data-target="gridview-4" data-toggle="tooltip" data-placement="top" title="4">4</a>
            <a class="grid-5" data-target="gridview-5" data-toggle="tooltip" data-placement="top" title="5">5</a>
            <a class="list" data-target="listview" data-toggle="tooltip" data-placement="top" title="List"><i class="fa fa-th-list"></i></a>
        </div>
        {{-- <div class="product-item-selection_area">
            <div class="product-short">
                <label class="select-label">Short By:</label>
                <select class="myniceselect nice-select">
                    <option value="1">Default</option>
                    <option value="2">Name, A to Z</option>
                    <option value="3">Name, Z to A</option>
                    <option value="4">Price, low to high</option>
                    <option value="5">Price, high to low</option>
                    <option value="5">Rating (Highest)</option>
                    <option value="5">Rating (Lowest)</option>
                </select>
            </div>
        </div> --}}
    </div>
    <div class="shop-product-wrap grid gridview-3 img-hover-effect_area row">
        @foreach ($products as $product)
            <div class="col-lg-4">
                <div class="product-slide_item">
                    <div class="inner-slide">
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{url('product')}}/{{$product->id}}">
                                    <img class="primary-img" src="{{optional(json_decode($product->photos))[0]}}" alt="{{ $product->name }}">
                                    <img class="secondary-img" src="{{optional(json_decode($product->photos))[1]}}" alt="{{ $product->name }}">
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
                                        <li><a class="uren-add_cart" href="{{url('product')}}/{{$product->id}}" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i
                                            class="ion-bag"></i></a>
                                        </li>
                                        @auth
                                            <li><a class="uren-wishlist" href="wishlist" data-toggle="tooltip" data-placement="top" title="Add To Wishlist" ng-click="addToWishList({{$product}})"><i
                                                class="ion-android-favorite-outline"></i></a>
                                            </li>
                                        @endauth
                                        {{-- <li class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter" onclick="selectedProduct('{{$product->id}}', '{{$product->name}}', '{{$product->price}}', '{{$product->description}}', '{{ URL::to(optional(json_decode($product->photos))[0])}}')"><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Quick View"><i
                                            class="ion-android-open"></i></a></li> --}}
                                        <li class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter{{$product->id}}" ng-click="selectedProduct({{$product}}, {{$product->reviews}})"><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Quick View"><i
                                            class="ion-android-open"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-desc_info">
                                    <div class="rating-box">
                                        @include('includes.rating')
                                    </div>
                                    <h6><a class="product-name" href="{{url('product')}}/{{$product->id}}">{{$product->name}}</a></h6>
                                    <div class="price-box">
                                        <span class="new-price">&#x20A6;{{$product->price}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-slide_item">
                    <div class="single-product">
                        <div class="product-img">
                            <a href="product/{{$product->id}}">
                                <img class="primary-img" src="{{optional(json_decode($product->photos))[0]}}" alt="{{ $product->name }}">
                                <img class="secondary-img" src="{{optional(json_decode($product->photos))[1]}}" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="product-content">
                            <div class="product-desc_info">
                                <div class="rating-box">
                                    @include('includes.rating')
                                </div>
                                <h6><a class="product-name" href="product/{{$product->id}}">{{$product->name}}</a></h6>
                                <div class="price-box">
                                    <span class="new-price">&#x20A6;{{$product->price}}</span>
                                </div>
                                <div class="product-short_desc">
                                    <p>{!! $product->description !!}
                                    </p>
                                </div>
                            </div>
                            <div class="add-actions">
                                <ul>
                                    <li><a class="uren-add_cart" href="{{url('product')}}/{{$product->id}}" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="ion-bag"></i></a>
                                    </li>
                                    @auth
                                        <li><a class="uren-wishlist" href="wishlist" data-toggle="tooltip" data-placement="top" title="Add To Wishlist" ng-click="addToWishList({{$product}})"><i
                                            class="ion-android-favorite-outline"></i></a>
                                        </li>
                                    @endauth
                                    
                                    <li class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Quick View"><i
                                        class="ion-android-open"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('includes.quick_view_modal')
        @endforeach
        
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="uren-paginatoin-area">
                <div class="row">
                    <div class="col-lg-12">
                        @if ($products->hasPages())
                        <ul class="uren-pagination-box primary-color">
                            {{-- Previous Page Link --}}
                            @if ($products->onFirstPage())
                                <li class="disabled" aria-disabled="true" aria-label="Previous">
                                    <span aria-hidden="true">&lsaquo;</span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $products->previousPageUrl() }}" rel="prev" aria-label="Previous">&lsaquo;</a>
                                </li>
                            @endif
                        
                            {{-- Display only 5 page links --}}
                            @php
                                $start = max(1, $products->currentPage() - 2);
                                $end = min($start + 4, $products->lastPage());
                            @endphp
                        
                            @for ($i = $start; $i <= $end; $i++)
                                <li class="{{ ($i == $products->currentPage()) ? 'active' : '' }}">
                                    <a href="{{ $products->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        
                            {{-- Next Page Link --}}
                            @if ($products->hasMorePages())
                                <li><a class="Next" href="{{ $products->nextPageUrl() }}" rel="next" aria-label="Next">&rsaquo;</a></li>
                            @else
                                <li class="disabled" aria-disabled="true" aria-label="Next">
                                    <span aria-hidden="true">&rsaquo;</span>
                                </li>
                            @endif
                        </ul>
                        
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>