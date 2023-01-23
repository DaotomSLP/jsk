@extends('testdesign.layout')

@section('body')
    <div class="container">
        <div class="row pt-5">
            <div class="col-lg-3 col-12 order-2 order-lg-1 mt-lg-0 mt-3">
                <div class="card bg-dark card-shadow">
                    <div class="card-header">
                        <p class="h5 Text-secondary">ຄົ້ນຫາແບບເຮືອນ</p>
                    </div>
                    <form method="GET" action="search">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 py-2">
                                    <select class="form-select" name="floor" aria-label="Default select example">
                                        <option selected>ຈຳນວນຊັ້ນ</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="col-12 py-2">
                                    <select class="form-select" name="bedroom" aria-label="Default select example">
                                        <option selected>ຫ້ອງນອນ</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="col-12 py-2">
                                    <select class="form-select" name="bath" aria-label="Default select example">
                                        <option selected>ຫ້ອງນ້ຳ</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 pt-3">
                                    <button type="submit" class="btn Btn-outline-secondary px-5">ຄົ້ນຫາ</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-9 col-12 order-1 order-lg-2">
                <div id="carouselBanner" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach ($homeSlideImages as $key => $homeSlideImage)
                            <button type="button" data-bs-target="#carouselBanner" data-bs-slide-to={{ $key }}
                                class="{{ $key == 0 ? 'active' : '' }}" aria-current="true">
                            </button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach ($homeSlideImages as $key => $homeSlideImage)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <a href="{{ $homeSlideImage->link }}">
                                    <img src="/img/design/slide/{{ $homeSlideImage->img_src }}" class="d-block w-100"
                                        alt="...">
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev Text-secondary" type="button" data-bs-target="#carouselBanner"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselBanner"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="row pt-5 mt-5">
            <div class="col-12 text-center">
                <p class="h4 font-weight-bolder text-uppercase Text-secondary">
                    Top Selling
                </p>
            </div>
            <div class="col-12">
                <div id="carouselRecommended" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach ($topSellingSlideImages as $key => $topSellingSlideImage)
                            <button type="button" data-bs-target="#carouselRecommended"
                                data-bs-slide-to={{ $key }} class="{{ $key == 0 ? 'active' : '' }}"
                                aria-current="true">
                            </button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach ($topSellingSlideImages as $key => $topSellingSlideImage)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <a href="{{ $topSellingSlideImage->link }}">
                                    <img src="/img/design/slide/{{ $topSellingSlideImage->img_src }}" class="d-block w-100"
                                        alt="...">
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev Text-secondary" type="button"
                        data-bs-target="#carouselRecommended" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselRecommended"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        @foreach ($category_plans as $category_plan)
            @if (sizeof($category_plan['plans']) > 0)
                <div class="row pt-5">
                    <div class="col-9">
                        <p class="h4 font-weight-bolder text-uppercase headertext-symbol Text-secondary">
                            {{ $category_plan['cate_name'] }}
                        </p>
                    </div>
                    <div class="col-3">
                        <a href="/plansByCategory/{{ $category_plan['id'] }}">
                            <p class="h5 font-weight-bolder text-right text-uppercase Text-secondary mb-0">
                                ສະແດງທັງໝົດ >>
                            </p>
                        </a>
                    </div>
                    @foreach ($category_plan['plans'] as $plan)
                        <div class="col-12 col-lg-4 col-md-6 pt-3">
                            <a href="/detail/{{ $plan->id }}">
                                <div class="card bg-dark card-shadow plan-card">
                                    <img class="card-img-top plan-card-image" src="/img/design/{{ $plan->thumbnail }}"
                                        alt="Card image cap">
                                    <div class="card-body plan-card-body bg-dark">
                                        <p class="text-white font-weight-bolder h5">
                                            {{ $plan->plan_name }}
                                        </p>
                                        <p class="text-white font-weight-lighter mb-0">
                                            {{ $plan->cate_name }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
@endsection
