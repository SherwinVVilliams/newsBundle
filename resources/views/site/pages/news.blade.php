@extends('site.layouts.app')

@section('content')
<link rel="stylesheet" href="/site/plugin/hover__master/hover.css">


<main class="news__wrap">
    <div class="news__top">
        <div class=" news__wrapper container">
            <div class="news__content ">
                <div class="news__title ">
                    <h2>Новости</h2>
                    <div class="news__img">
                        <img src="/site/img/news/title.png" alt="title__news">
                    </div>
                </div>
                <div class="news__tabs">
                    <div class="news__tabs-title">
                        <h2>Категория:</h2>
                    </div>
                    <ul class="tabs__caption-news">
                        @foreach($categories as $k=>$category)
                            @if($category->name != 'Акции')
                                <li class="{{ ( $category->alias == $alias ) ? 'active' : ''}}">
                                    <a  href="{{ route('news', ['alias' => $category->alias != 'all'
                                     ? $category->alias : '']) }}">{{ $category->name }}</a>
                                </li>
                            @else
                                <li class="news__active {{ $category->alias == $alias ? 'active' : '' }}" >
                                    <a href="{{  route('news', ['alias' => $category->alias]) }}">{{ $category->name }}</a>
                                </li>
                            @endif
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>

    </div>
    <div class="tabss__content">
        <div class="news__blocks container active__blocks">
            @foreach($news as $item)
            <div data-aos="fade-up" class="news__block" >
                <div class="row justify-content-between">
                    <div class="col-lg-6 col-12">
                        <div class="news__pict">
                            <a href="descnews.php">
                                <img src="{{U::pathID(json_decode($item->image_id)[0], '539x352')}}" alt="news1">
                            </a>
                            @if(isset($item->discount))
                            <div class="news__pict-arrow wow fadeInLeft" data-wow-offset="200"
                                 data-wow-delay="0.5s"
                                 data-wow-duration="1s" >
                                <span>{{ $item->discount }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 news__info">
                        <div class="news__info-title">
                            <a href="#">
                                {{ $item->title }}
                            </a >
                        </div>
                        <div class="news__info-text">
                            <p>
                               {{ str_limit($item->desc, 250) }}
                            </p>
                        </div>
                        <div class="row justify-content-between news__info-foot">
                            <div class=" col-md-6 col-sm-7 col-6 info__date">
                        <span class="info__date-write">
                           {{ $item->created_at ? $item->created_at->format('d.m.Y') : '' }}
                        </span>
                                <span class="info__shops">
                            {{ $item->category->name }}
                        </span>
                            </div>
                            <div class="col-md-6 col-sm-5 col-6 info__detailed">
                                <a href="descnews.php">Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        <div class="news__pagination">
            <section class="section-pagination">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="section-pagination__content">
                                @if($news->lastPage() > 1)

                                    @if($news->currentPage() !== 1)
                                    <a class="arrow-left " href="{{ $news->url($news->currentPage() - 1)}}">
                                        <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15.6 15.5" style="enable-background:new 0 0 15.6 15.5;" xml:space="preserve">
                                        <style type="text/css">
                                            .st0 {
                                                fill: #434343;
                                            }
                                        </style>
                                                    <g>
                                                        <g>
                                                            <path class="st0" d="M15.4,12.3c-0.1,0.1-0.3,0.2-0.4,0.2c-0.3,0-0.6-0.3-0.6-0.6l0-9.8L1,15.4c-0.2,0.2-0.6,0.2-0.8,0
                                                    c-0.2-0.2-0.2-0.6,0-0.8L13.5,1.2l-9.8,0C3.6,1.2,3.4,1.1,3.3,1C3.2,0.9,3.1,0.8,3.1,0.6c0-0.2,0.1-0.3,0.2-0.4
                                                    C3.4,0.1,3.6,0,3.7,0L15,0c0.2,0,0.3,0.1,0.4,0.2c0.1,0.1,0.2,0.3,0.2,0.4l0,11.3C15.6,12,15.5,12.2,15.4,12.3z"></path>
                                                        </g>
                                                    </g>

                                        </svg>
                                    </a>
                                    @endif
                                @for($i = 1; $i< $news->lastPage()+1; ++$i)

                                    @if($i == $news->currentPage())

                                        @if($news->currentPage() != 1)
                                        <a class="number" href = "{{ $news->url(1) }} ">{{ 1 }}</a>
                                        @endif

                                        @if($news->currentPage() != 2&&$news->currentPage() != 1)
                                        <a class="number" href = "{{ $news->url(2) }} ">{{ 2 }}</a>
                                        @endif

                                        @if($i-2 > 2)
                                            <a class="number" href = "{{ $news->url($i-2) }} ">...</a>
                                        @endif

                                        @if($i-1 > 2)
                                            <a class="number" href = "{{ $news->url($i-1) }} ">{{ $i-1 }}</a>
                                        @endif

                                        <a class="active number" href="">{{ $i }}</a>

                                        @if($i+1 < $news->lastPage()-1)
                                            <a class="number" href = " {{ $news->url($i+1) }}">{{ $i+1 }}</a>
                                        @endif

                                        @if($i+2 < $news->lastPage()-1)
                                            <a class="number" href = " {{ $news->url($i+2) }}">...</a>
                                        @endif

                                        @if($news->currentPage() != $news->lastPage()-1 && $news->currentPage() != $news->lastPage())
                                        <a class="number" href = "{{ $news->url($news->lastPage()-1) }} ">{{ $news->lastPage()-1 }}</a>
                                        @endif

                                        @if($news->currentPage() != $news->lastPage())
                                        <a class="number" href = "{{ $news->url($news->lastPage()) }} ">{{ $news->lastPage() }}</a>
                                        @endif
                                      
                                   @endif

                                @endfor
                                
                                @if($news->currentPage() !== $news->lastPage())
                                <a class="arrow-right" href="{{ $news->url($news->currentPage() + 1)}}">
                                    <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15.6 15.5" style="enable-background:new 0 0 15.6 15.5;" xml:space="preserve">
                                    <style type="text/css">
                                        .st0 {
                                            fill: #434343;
                                        }
                                    </style>
                                                <g>
                                                    <g>
                                                        <path class="st0" d="M15.4,12.3c-0.1,0.1-0.3,0.2-0.4,0.2c-0.3,0-0.6-0.3-0.6-0.6l0-9.8L1,15.4c-0.2,0.2-0.6,0.2-0.8,0
                                                c-0.2-0.2-0.2-0.6,0-0.8L13.5,1.2l-9.8,0C3.6,1.2,3.4,1.1,3.3,1C3.2,0.9,3.1,0.8,3.1,0.6c0-0.2,0.1-0.3,0.2-0.4
                                                C3.4,0.1,3.6,0,3.7,0L15,0c0.2,0,0.3,0.1,0.4,0.2c0.1,0.1,0.2,0.3,0.2,0.4l0,11.3C15.6,12,15.5,12.2,15.4,12.3z"></path>
                                                    </g>
                                                </g>

                                    </svg>
                                </a>
                                @endif
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>


</main>
<script type="text/javascript" src="/site/js/main/sliderSale.js"></script>
<script type="text/javascript" src="/site/js/main/validateMain.js"></script>
<script type="text/javascript" src="/site/js/fancyboxMain.js"></script>
<script src="/site/js/news/news.js"></script>
@endsection