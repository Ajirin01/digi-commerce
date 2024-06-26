@php
    $brands = App\Models\Brand::inRandomOrder()->limit(20)->get();
@endphp
<div class="uren-brand_area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title_area">
                    <span>Top Quality Partner</span>
                    <h3>Shop By Brands</h3>
                </div>
                <div class="brand-slider uren-slick-slider img-hover-effect_area" data-slick-options='{
                "slidesToShow": 6
                }' data-slick-responsive='[
                                        {"breakpoint":1200, "settings": {"slidesToShow": 5}},
                                        {"breakpoint":992, "settings": {"slidesToShow": 3}},
                                        {"breakpoint":767, "settings": {"slidesToShow": 3}},
                                        {"breakpoint":577, "settings": {"slidesToShow": 2}},
                                        {"breakpoint":321, "settings": {"slidesToShow": 1}}
                                    ]'>
                    @foreach ($brands as $brand)
                        <div class="slide-item">
                            <div class="inner-slide">
                                <div class="single-product">
                                    <a href="javascript:void(0)">
                                        <img src="{{$brand->photo}}" width="174px" height="106px" alt="{{$brand->name}}">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</div>