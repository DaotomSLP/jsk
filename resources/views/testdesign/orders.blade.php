@extends('testdesign.layout')

@section('body')
    <div class="container pt-5 mt-5 mt-lg-1">
        <div class="row">
            <div class="col-12">
                <p class="h4 font-weight-bolder text-uppercase headertext-symbol Text-secondary">
                    {{ __('home.past_project') }} :
                </p>
            </div>
        </div>

        <div class="row ">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg ftco_navbar ftco-navbar-light">
                    <div class="container-fluid">
                        <div id="ftco-nav">
                            <ul class="navbar-nav m-auto">
                                <li class="nav-item {{ $status == 'pending' ? 'active' : '' }}">
                                    <a href="/orders?status=pending" class="nav-link">{{ __('orders.pending_payment') }}
                                    </a>
                                </li>
                                <li class="nav-item  {{ $status == 'success' ? 'active' : '' }}">
                                    <a href="/orders?status=success" class="nav-link">{{ __('orders.success') }}
                                    </a>
                                </li>
                                <li class="nav-item  {{ $status == 'cancelled' ? 'active' : '' }}">
                                    <a href="/orders?status=cancelled" class="nav-link">{{ __('orders.cancelled') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        @if (sizeOf($orders) == 0)
            <div class="row pt-5 mt-5 mt-lg-1 justify-content-center">
                <div class="col-12 col-lg-6">
                    <img src="/img/design/not_found.jpg" class="img-fluid d-block" style="margin-inline: auto">
                    <p class="Text-secondary text-center font-weight-bolder h4 mt-5">
                        {{ __('home.no_result') }}
                    </p>
                </div>
            </div>
        @else
            <div class="row pt-3 mt-5 mt-lg-1">
                <div class="col-12">
                    @foreach ($orders as $order)
                        <div class="row py-2">
                            <div class="col-2">
                                <img class="card-img-top plan-card-image"
                                    src="/img/design/{{ $order->thumbnail ? $order->thumbnail : 'no_image.jpeg' }}"
                                    alt="Card image cap">
                            </div>
                            <div class="col-4">
                                <p>
                                    {{ $order->order_no }}
                                </p>
                                <p class="h6 font-weight-bolder Text-secondary">
                                    {{ App::getLocale() == 'la' ? $order->plan_name : (App::getLocale() == 'en' ? ($order->plan_en_name ? $order->plan_en_name : $order->plan_name) : ($order->plan_cn_name ? $order->plan_cn_name : $order->plan_name)) }}
                                </p>
                                <p class="text-white font-weight-lighter mb-0">
                                    {{ App::getLocale() == 'la' ? $order->cate_name : (App::getLocale() == 'en' ? ($order->cate_en_name ? $order->cate_en_name : $order->cate_name) : ($order->cate_cn_name ? $order->cate_cn_name : $order->cate_name)) }}
                                </p>
                            </div>
                            <div class="col-4">
                                <p class="text-white font-weight-lighter mb-0">
                                    {{ App::getLocale() == 'la' ? $order->name : (App::getLocale() == 'en' ? ($order->en_name ? $order->en_name : $order->name) : ($order->cn_name ? $order->cn_name : $order->name)) }}
                                </p>
                                <p class="h6 font-weight-bolder Text-secondary">
                                    {{ number_format($order->price) }} &#x24;
                                </p>
                            </div>
                            <div class="col-2">
                                <a href="/order" class="btn Btn-outline-secondary px-5">
                                    {{ __('orders.pay') }}
                                </a>
                            </div>
                        </div>
                        <hr />
                    @endforeach
                </div>
            </div>

            <div class="row mt-5">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $pagination['offset'] == 1 ? 'disabled' : '' }}">
                            <a class="Text-secondary bg-dark page-link"
                                href="/showPastWorks?page={{ $pagination['offset'] - 1 }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item {{ $pagination['offset'] == '1' ? 'active' : '' }}">
                            <a class="Text-secondary bg-dark page-link" href="/showPastWorks?page=1">1</a>
                        </li>
                        @for ($j = $pagination['offset'] - 25; $j < $pagination['offset'] - 10; $j++)
                            @if ($j % 10 == 0 && $j > 1)
                                <li
                                    class="page-item
                                {{ $pagination['offset'] == $j ? 'active' : '' }}">
                                    <a class="Text-secondary bg-dark page-link"
                                        href="/showPastWorks?page={{ $j }}">{{ $j }}</a>
                                </li>
                            @else
                            @endif
                        @endfor
                        @for ($i = $pagination['offset'] - 4; $i <= $pagination['offset'] + 4 && $i <= $pagination['offsets']; $i++)
                            @if ($i > 1 && $i <= $pagination['all'])
                                <li class="page-item {{ $pagination['offset'] == $i ? 'active' : '' }}">
                                    <a class="Text-secondary bg-dark page-link"
                                        href="/showPastWorks?page={{ $i }}">{{ $i }}</a>
                                </li>
                            @else
                            @endif
                        @endfor
                        @for ($j = $pagination['offset'] + 5; $j <= $pagination['offset'] + 20 && $j <= $pagination['offsets']; $j++)
                            @if ($j % 10 == 0 && $j > 1)
                                <li
                                    class="page-item
                                {{ $pagination['offset'] == $j ? 'active' : '' }}">
                                    <a class="Text-secondary bg-dark page-link"
                                        href="/showPastWorks?page={{ $j }}">{{ $j }}</a>
                                </li>
                            @else
                            @endif
                        @endfor
                        <li class="page-item {{ $pagination['offset'] == $pagination['offsets'] ? 'disabled' : '' }}">
                            <a class="Text-secondary bg-dark page-link"
                                href="/showPastWorks?page={{ $pagination['offset'] + 1 }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        @endif
    </div>
    </div>
@endsection
