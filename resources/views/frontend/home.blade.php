@extends('frontend.layouts.app')

@section('content')
<div class="iq-banner-thumb-slider">
  <div class="slider">
    <div class="position-relative slider-bg d-flex justify-content-end">
      <div class="position-relative my-auto">
        <div class="horizontal_thumb_slider" data-swiper="slider-thumbs-ott">
          <div class="banner-thumb-slider-nav">
            <div class="swiper-container " data-swiper="slider-thumbs-inner-ott">
              <div class="swiper-wrapper">

                @foreach ($movies as $movie)
                <div class="swiper-slide swiper-bg">
                  <div class="block-images position-relative">
                    <div class="img-box">
                      <img src="{{ asset($movie['image']) }}" class="img-fluid" alt="{{ $movie['title'] }}"
                        loading="lazy">
                      <div class="block-description">
                        <h6 class="iq-title fw-500 mb-0">{{ $movie['title'] }}</h6>
                        <span class="fs-12">{{ $movie['duration'] }}</span>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach

              </div>
            </div>
            <div class="slider-prev swiper-button">
              <i class="iconly-Arrow-Left-2 icli"></i>
            </div>
            <div class="slider-next swiper-button">
              <i class="iconly-Arrow-Right-2 icli"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="slider-images" data-swiper="slider-images-ott">
        <div class="swiper-container" data-swiper="slider-images-inner-ott">
          <div class="swiper-wrapper m-0">
            @foreach ($movies as $movie)
            <div class="swiper-slide p-0">
              <div class="slider--image block-images">
                <img src="{{ asset($movie['image']) }}" loading="lazy" alt="{{ $movie['title'] }}" />
              </div>
              <div class="description">
                <div class="row align-items-center h-100">
                  <div class="col-lg-6 col-md-12">
                    <div class="slider-content">
                      <h1 class="texture-text big-font letter-spacing-1 line-count-1 text-capitalize RightAnimate-two">
                        {{ $movie['title'] }}
                      </h1>
                      <p class="line-count-3 RightAnimate-two">{{ $movie['description'] }}</p>
                    </div>
                    <div class="RightAnimate-four">
                      <div class="iq-button">
                        <a href="#" class="btn text-uppercase position-relative">
                          <span class="button-text">See Detail</span>
                          <i class="fa-solid fa-play"></i>
                        </a>
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
</div>

<div class="top-ten-block section-padding-top">
  <div class="container-fluid">
    <section class="overflow-hidden">
      <div class="d-flex align-items-center justify-content-between px-md-3 px-1 mb-4">
        <h5 class="main-title text-capitalize mb-0">Top Ten Subject</h5>
        <a href="#" class="text-primary iq-view-all text-decoration-none flex-none">View All</a>
      </div>
      <div class="position-relative swiper swiper-card iq-top-ten-block-slider" data-slide="6" data-laptop="6"
        data-tab="3" data-mobile="2" data-mobile-sm="2" data-autoplay="false" data-loop="false" data-navigation="true"
        data-pagination="true">
        <ul class="p-0 swiper-wrapper mb-5 list-inline">
          @foreach($topTenSubject as $subject)
          <li class="swiper-slide">
            <div class="iq-top-ten-block">
              <div class="block-image position-relative">
                <div class="img-box">
                  <a class="overly-images" href="#">
                    <img src="{{ asset($subject['image']) }}" alt="movie-card"
                      class="img-fluid object-cover w-100 d-block border-0">
                  </a>
                  <span class="top-ten-numbers texture-text">{{ $subject['rank'] }}</span>
                </div>
              </div>
            </div>
          </li>
          @endforeach
        </ul>
        <div class="swiper-button swiper-button-next"></div>
        <div class="swiper-button swiper-button-prev"></div>
      </div>
    </section>
  </div>
</div>

<div class="streamit-block">
  <div class="container-fluid">
    <div class="overflow-hidden">
      <div class="d-flex align-items-center justify-content-between px-md-3 px-1 my-4">
        <h5 class="main-title text-capitalize mb-0">Most liked tutor</h5>
        <a href="#" class="text-primary iq-view-all text-decoration-none flex-none">View All</a>
      </div>
      <div class="card-style-slider">
        <div class="position-relative swiper swiper-card" data-slide="6" data-laptop="6" data-tab="3" data-mobile="2"
          data-mobile-sm="2" data-autoplay="false" data-loop="true" data-navigation="true" data-pagination="true">
          <ul class="p-0 swiper-wrapper m-0  list-inline">
            @foreach($mostLikedTutor as $likedTutor)
            <li class="swiper-slide">
              <div class="iq-card card-hover">
                <div class="block-images position-relative w-100">
                  <div class="img-box w-100">
                    <a href="#" class="position-absolute top-0 bottom-0 start-0 end-0"></a>
                    <img src="{{ asset($likedTutor['image']) }}" alt="movie-card"
                      class="img-fluid object-cover w-100 d-block border-0">
                  </div>
                  <div class="card-description with-transition">
                    <div class="cart-content">
                      <div class="content-left">
                        <h5 class="iq-title text-capitalize">
                          <a href="#">{{ $likedTutor['name'] }}</a>
                        </h5>
                        <div class="movie-time d-flex align-items-center my-2">
                          <span class="movie-time-text font-normal">{{ $likedTutor['like'] }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="block-social-info align-items-center">
                    <ul class="p-0 m-0 d-flex gap-2 music-play-lists">
                      <li class="share position-relative d-flex align-items-center text-center mb-0">
                        <span class="w-100 h-100 d-inline-block bg-transparent">
                          <i class="fa-regular fa-heart"></i>
                        </span>
                        <div class="share-wrapper">
                          <div class="share-boxs d-inline-block">
                            <svg width="15" height="40" class="share-shape" viewBox="0 0 15 40" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M14.8842 40C6.82983 37.2868 1 29.3582 1 20C1 10.6418 6.82983 2.71323 14.8842 0H0V40H14.8842Z"
                                fill="#191919"></path>
                            </svg>
                            <div class=" overflow-hidden">
                              <span>+51</span>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </li>
            @endforeach
          </ul>
          <div class="swiper-button swiper-button-next"></div>
          <div class="swiper-button swiper-button-prev"></div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection