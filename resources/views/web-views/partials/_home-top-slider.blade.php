<style>
    .just-padding {
        padding: 15px;
        border: 1px solid #ccccccb3;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        height: 100%;
        background-color: white;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 7% !important;
    }
</style>

<div class="row rtl">
    <div class="col-xl-3 d-none d-xl-block">
        <div></div>
    </div>

    <div class="col-xl-9 col-md-12"
        style="margin-top: 3px;{{ Session::get('direction') === 'rtl' ? 'padding-right:10px;' : 'padding-left:10px;' }}">
        @php(
    $main_banner = \App\Model\Banner::where('banner_type', 'Main Banner')->where('city', $default_city)->where('published', 1)->orderBy('id', 'desc')->get())
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($main_banner as $key => $banner)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}"
                        class="{{ $key == 0 ? 'active' : '' }}">
                    </li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach ($main_banner as $key => $banner)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <a href="{{ $banner['url'] }}">
                            <img class="d-block w-100" style="max-height: 372px;"
                                onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                                src="{{ asset('storage/app/public/banner') }}/{{ $banner['photo'] }}" alt="">
                        </a>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">{{ \App\CPU\translate('Previous') }}</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">{{ \App\CPU\translate('Next') }}</span>
            </a>
        </div>

        {{-- <div class="row mt-2">
            @foreach (\App\Model\Banner::where('banner_type', 'Footer Banner')->where('published', 1)->orderBy('id', 'desc')->take(3)->get() as $banner)
                <div class="col-4">
                    <a data-toggle="modal" data-target="#quick_banner{{$banner->id}}"
                       style="cursor: pointer;">
                        <img class="d-block footer_banner_img" style="width: 100%"
                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                             src="{{asset('storage/app/public/banner')}}/{{$banner['photo']}}">
                    </a>
                </div>
                <div class="modal fade" id="quick_banner{{$banner->id}}" tabindex="-1"
                     role="dialog" aria-labelledby="exampleModalLongTitle"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p class="modal-title"
                                   id="exampleModalLongTitle">{{ \App\CPU\translate('banner_photo')}}</p>
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img class="d-block mx-auto"
                                     onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                     src="{{asset('storage/app/public/banner')}}/{{$banner['photo']}}">
                                @if ($banner->url != '')
                                    <div class="text-center mt-2">
                                        <a href="{{$banner->url}}"
                                           class="btn btn-outline-accent">{{\App\CPU\translate('Explore')}} {{\App\CPU\translate('Now')}}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> --}}
    </div>
    <!-- Banner group-->
</div>


<script>
    $(function() {
        $('.list-group-item').on('click', function() {
            $('.glyphicon', this)
                .toggleClass('glyphicon-chevron-right')
                .toggleClass('glyphicon-chevron-down');
        });
    });
</script>
