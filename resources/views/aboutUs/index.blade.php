
@extends('layouts.master')

@section('title', 'About Us')

@section('main')
    <main class="flex-shrink-0">
        <div class="header-container">
            <div class="header-caption">
                <div class="header-title">{!! $page_properties?$page_properties->slider_title:"About Us"; !!}</div>
                <p>{!! $page_properties?$page_properties->slider_caption:"Creating Unforgettable Moments with Our Exclusive Wedding Rentals"; !!}</p>
            </div>
        </div>
        <div class="about-us">
            <!-- Our Story Section -->
            <section class="our-story py-5">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="about-title ">Our Story</div>
                            <div class="description-business">
                                {!! $business->story !!}
                            </div>
                            <div class="about-title">About Us</div>
                            <div class="description-business">
                                {!! $business->description !!}
                            </div>
                            <div class="visi-misi">
                                <div class="about-title">Vision</div>
                                <div class="description-business">
                                    {!! $business->vision !!}
                                </div>
                                <div class="about-title">Missions</div>
                                <div class="list-business">
                                    {!! $business->mission !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="img-potrait">
                                <img src="{{ asset('images/business/about_us.jpeg') }}" alt="Wedding Decor" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        
            
        
            <!-- PRODUCT -->
            <section class="product py-5">
                <div class="container text-center">
                    <div id="popularProduct">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach ($popularProducts as $popular_product)
                                    <div class="swiper-slide" id="popularProduct">
                                        <div class="card">
                                            <div class="card-img">
                                                <img src="{{ asset('images/products/'.$popular_product->cover) }}" class="card-img-top" alt="{{ $popular_product->category }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Our Values Section -->
            <section class="our-values py-5">
                <div class="container text-center">
                    <h2 class="about-title m-b-45">Our Values</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <i class="fas fa-gem fa-3x mb-3 text-primary"></i>
                            <h4>Elegance</h4>
                            <p>We offer a wide selection of beautiful, sophisticated rental items that add a touch of elegance to your wedding day.</p>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-heart fa-3x mb-3 text-primary"></i>
                            <h4>Passion</h4>
                            <p>We are passionate about weddings, and we love helping couples create the celebration of their dreams.</p>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-thumbs-up fa-3x mb-3 text-primary"></i>
                            <h4>Professionalism</h4>
                            <p>Our team provides exceptional service from start to finish, ensuring that every event runs smoothly and flawlessly.</p>
                        </div>
                    </div>
                </div>
            </section>
            @include('layouts.partials.footer')
        </div>
        <script>
            var swiper = new Swiper('.swiper-container', {
                spaceBetween: 18,
                autoplay: {
                    delay: 6000, 
                    disableOnInteraction: true,
                },
                grabCursor: true,
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    1024: {
                        slidesPerView: 4,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    640: {
                        slidesPerView: 1.5,
                    }
                }
            });
            
        </script>
    </main>
@endsection

