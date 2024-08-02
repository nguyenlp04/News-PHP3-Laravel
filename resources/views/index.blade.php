@extends('layout/main')
@section('content')
<main>
    <!-- Trending Area Start -->
    <div class="trending-area fix">
        <div class="container">
            <div class="trending-main">
                <!-- Trending Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="trending-tittle">
                            <strong>Trending now</strong>
                            <!-- <p>Rem ipsum dolor sit amet, consectetur adipisicing elit.</p> -->
                            <div class="trending-animated">
                                <ul id="js-news" class="js-hidden">
                                    <li class="news-item">Bangladesh dolor sit amet, consectetur adipisicing elit.</li>
                                    <li class="news-item">Spondon IT sit amet, consectetur.......</li>
                                    <li class="news-item">Rem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Trending Top -->
                        <div class="trending-top mb-30">
                            <div class="trend-top-img">
                                <img height="450px" src="{{ asset($featuredArticle->image_url) }}" alt="">
                                <div class="trend-top-cap">
                                    <span>{{ $featuredArticle->categories_name }}</span>
                                    <h2><a href="{{ url('article/' . $featuredArticle->id) }}">{{ $featuredArticle->title }}</a></h2>
                                </div>
                            </div>
                        </div>
                        <!-- Trending Bottom -->
                        <div class="trending-bottom">
                            <div class="row">
                                @foreach($subArticles as $item)
                                <div class="col-lg-4">
                                    <div class="single-bottom mb-35">
                                        <div class="trend-bottom-img mb-30">
                                            <img src="{{ asset($item->image_url) }}" alt="">
                                        </div>
                                        <div class="trend-bottom-cap">
                                            <span class="color1">{{ $item->categories_name }}</span>
                                            <h4><a href="{{ url('article/' . $item->id) }}">{{ $item->title }}</a></h4>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Riht content -->
                    <div class="col-lg-4">
                        @foreach($sideArticles as $item)
                        <div class="trand-right-single d-flex">
                            <div class="trand-right-img">
                                <img width="100px" src="{{ asset($item->image_url) }}" alt="">
                            </div>
                            <div class="trand-right-cap">
                                <span class="color1">{{ $item->categories_name }}</span>
                                <h4><a href="{{ url('article/' . $item->id) }}">{{ $item->title }}</a></h4>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Trending Area End -->
    <!--   Weekly-News start -->
    <div class="weekly-news-area pt-50">
        <div class="container">
          
        </div>
    </div>
    <!-- End Weekly-News -->
    <!-- Whats New Start -->
    <section class="whats-news-area pt-50 pb-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row d-flex justify-content-between">
                        <div class="col-lg-3 col-md-3">
                            <div class="section-tittle mb-30">
                                <h3>Whats New</h3>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9">
                            <div class="properties__button">
                                <!--Nav Button  -->
                                <nav class="d-flex justify-content-between align-items-center">
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">All</a>
                                        @foreach($categories as $item)
                                        <a class="nav-item nav-link" id="nav-{{ $item->id }}-tab" data-toggle="tab" href="#nav-{{ $item->id }}" role="tab" aria-controls="nav-profile" aria-selected="false">{{ $item->name }}</a>
                                        @endforeach
                                        <!-- <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Travel</a>
                                    <a class="nav-item nav-link" id="nav-last-tab" data-toggle="tab" href="#nav-last" role="tab" aria-controls="nav-contact" aria-selected="false">Fashion</a>
                                    <a class="nav-item nav-link" id="nav-Sports" data-toggle="tab" href="#nav-nav-Sport" role="tab" aria-controls="nav-contact" aria-selected="false">Sports</a>
                                    <a class="nav-item nav-link" id="nav-technology" data-toggle="tab" href="#nav-techno" role="tab" aria-controls="nav-contact" aria-selected="false">Technology</a> -->
                                    </div>
                                    <a href="{{ url('categori') }}" style="margin-bottom: 31px; font-size: 25px; font-weight: 400; color: black">View All&nbsp;<i class="fa-solid fa-arrow-right"></i></a>
                                </nav>
                                <!--End Nav Button  -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <!-- Nav Card -->
                            <div class="tab-content" id="nav-tabContent">
                                <!-- card one -->
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="whats-news-caption">
                                        <div class="row">
                                            @foreach($allArticles as $item)
                                            <div class="col-lg-3 col-md-3">
                                                <div class="single-what-news mb-100">
                                                    <div class="what-img">
                                                        <img src="{{ asset($item->image_url) }}" alt="">
                                                    </div>
                                                    <div class="what-cap">
                                                        <span class="color1">{{ $item->categories_name }}</span>
                                                        <h4><a href="{{ url('article/' . $item->id) }}">{{ $item->title }}</a></h4>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- Card two -->
                               

                            </div>
                            <!-- End Nav Card -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Whats New End -->
    <!--   Weekly2-News start -->
    <div class="weekly2-news-area  weekly2-pading gray-bg">
        <div class="container">
            <div class="weekly2-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle mb-30">
                            <h3>Weekly Top News</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="weekly2-news-active dot-style d-flex dot-style">
                        @foreach($weeklyTopNews as $item)
                            @endforeach
                            @foreach($weeklyTopNews as $item)
                            <div class="weekly2-single">
                                <div class="weekly2-img">
                                    <img src="{{ asset($item->image_url) }}" alt="">
                                </div>
                                <div class="weekly2-caption">
                                    <span class="color1">{{ $item->categories_name }}</span>
                                    <p>{{ $item->created_at }}</p>
                                    <h4><a href="{{ url('article/' . $item->id) }}">{{ $item->title }}</a></h4>
                                </div>
                            </div> 
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Weekly-News -->
    <!--  Recent Articles start -->
    <div class="recent-articles pt-5 pb-5">
        <div class="container">
            <div class="recent-wrapper">
                <!-- section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle mb-30">
                            <h3>Recommended Articles</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="recent-active dot-style d-flex dot-style">
                            @foreach($recommendedArticles as $item)
                            <div class="single-recent mb-100">
                                <div class="what-img">
                                    <img src="{{ $item->image_url }}" alt="">
                                </div>
                                <div class="what-cap">
                                    <span class="color1">{{ $item->categories_name }}</span>
                                    <h4><a href="{{ url('article/' . $item->id) }}">{{ $item->title }}</a></h4>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Recent Articles End -->
    <!--Start pagination -->
    <!-- <div class="pagination-area pb-45 text-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="single-wrap d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-start">
                                <li class="page-item"><a class="page-link" href="#"><span class="flaticon-arrow roted"></span></a></li>
                                <li class="page-item active"><a class="page-link" href="#">01</a></li>
                                <li class="page-item"><a class="page-link" href="#">02</a></li>
                                <li class="page-item"><a class="page-link" href="#">03</a></li>
                                <li class="page-item"><a class="page-link" href="#"><span class="flaticon-arrow right-arrow"></span></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- End pagination  -->
</main>
@endsection