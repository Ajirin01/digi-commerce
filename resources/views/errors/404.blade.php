@extends('layouts.shop_layout')
@section('content')
    <div class="error404-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 ml-auto mr-auto text-center">
                    <div class="search-error-wrapper">
                        <h1>404</h1>
                        <h2>PAGE NOT BE FOUND</h2>
                        <p class="short_desc">Sorry but the page or PRODUCT you are looking for does not exist, have been
                            removed, name
                            changed or is temporarily unavailable.</p>
                        <form action="{{ url('search-results') }}" class="hm-searchbox" action="GET" id="search-form">
                            <div class="inner-error_form">
                                <input type="text" placeholder="Search..."  name="query" class="error-input-text">
                                <button type="submit" class="error-search_btn" onclick="document.getElementById('search-form').submit()"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                        <div class="uren-btn-ps_center"></div>
                        <a href="/" class="uren-error_btn">Back To Home Page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
