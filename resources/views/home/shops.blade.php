@extends('layouts.home.layout')

@section('content')
    <nav class="navbar navbar-default my-navbar navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="contain-elem1 navbar-left">

                <div class="navbar-left"><a class="navbar-brand" href="#">Brand</a></div>


                <div class="pull-left hidden-xs">
                    <a class="button-1" href="#"><i class="fa fa-plus"></i> فروشگاه خود را ثبت کنید</a>
                </div>


            </div>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>


            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="#">سوالات متداول</a></li>
                    <li><a href="#">قوانین و مقررات</a></li>
                    <li><a href="#">راهنما</a></li>
                    <li><a href="#">تماس با پشتیبانی</a></li>
                </ul>

            </div><!-- /.navbar-collapse -->


        </div><!-- /.container-fluid -->
    </nav>

    <div class="search-bar">
        <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
            <div class="area-search2">
                <i class="fa fa-search"></i>
                <div class="loading-box" id="loading">
                    <i class="loading"></i>
                </div>

                <div class="close-box" id="close-searches">
                    <i class="fa fa-close"></i>
                </div>

                <div class="btn-circle" data-toggle="tooltip" data-placement="right"
                     title="نمایش فروشگاه های اطراف من">
                    <i class="fa fa-map-marker"></i>
                </div>


                <input type="text" class="input-area-search2" id="search-area"
                       @if(isset($area))
                       value="{{"{$area->city->name} - {$area->name} منطقه {$area->area_num}" }}"
                       disabled="disabled"
                       @elseif(isset($city))
                       value="{{ $city->name }}"
                       disabled="disabled"
                       @endif
                       autocomplete="off"
                       placeholder="محله خود را جستحو کنید...">

                <div class="searches" id="searches">
                    <ul>
                    </ul>
                </div>

                <div class="status-shops">
                    <p> در محدوده انتخابی شما {{ $shops_count }} فروشگاه یافت شد. </p>
                </div>

            </div>


        </div>

    </div>

    <div class="clearfix"></div>
    <div class="container-fluid">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">خانه</a></li>
                @if(isset($area))
                    <li><a href="{{ url("shops?city_id={$area->city_id}") }}">فروشگاه های
                            شهر {{ $area->city->name }}</a>
                    </li>
                    <li class="active">{{ "{$area->name} منطقه {$area->area_num}" }}</li>
                @elseif(isset($city))
                    <li class="active">فروشگاه های شهر {{ $city->name }}</li>
                @else
                    <li class="active">فروشگاه ها</li>

                @endif
            </ol>
        </div>


        @foreach($shops as $shop)
            <div class="col-md-3">
                <div class="item-shop">
                    <div class="cover">
                        <img src="{{ url('uploads/'.$shop->logo) }}">
                    </div>

                    <div class="rating">

                        <div class="av-rating">
                            <span>امتیاز : 3.7</span>
                        </div>
                        <i class="fa fa-star rate-star"></i>
                        <i class="fa fa-star rate-star"></i>
                        <i class="fa fa-star rate-star"></i>
                        <i class="fa fa-star rate-star"></i>
                        <i class="fa fa-star rate-star"></i>

                        <div class="comments-count">
                            <span>( 0 نظر )</span>
                        </div>


                    </div>
                    <h2>{{ $shop->name }}</h2>
                    <div class="shop-address">
                        <span><i class="fa fa-map-marker"></i> {{ $shop->address }}</span>
                    </div>
                    <a class="button-3" href="{{ url("products/{$shop->id}") }}">مشاهده محصولات</a>
                </div>
            </div>
        @endforeach

        <div class="clearfix"></div>
        <div class="col-md-12">
            @if(Request::has('city_id') && !Request::has('area_id'))
                {{ $shops->appends(['city_id' => Request::get('city_id')] )->links() }}
            @elseif(Request::has('city_id') && Request::has('area_id'))
                {{ $shops->appends(['city_id' => Request::get('city_id'),'area_id' => Request::get('area_id')])->links() }}
            @elseif(!Request::has('city_id') && Request::has('area_id'))
                {{ $shops->appends(['area_id' => Request::get('area_id')])->links() }}
            @else
                {{ $shops->links() }}
            @endif
        </div>
    </div>


    <div class="app-section">
        <div class="container">
            <h2>نسخه اپلیکیشن کش بک</h2>
            <h3>با نصب اپلیکیشن کش بک خیلی راحت تر به امکانات دسترسی داشته باشید و از تخفیف ها زودتر از همه با خبر
                شوید</h3>

            <a href="#" class="button-2">دانلود نسخه اندروید</a>

        </div>

    </div>


    <div class="footer">
        <div class="container">
            <span>تمامی حقوق مربوط به وب سایت کش بک میباشد</span>
        </div>
        <div class="clearfix"></div>
    </div>





@endsection



@section('custom_scripts')
    <script>

        $(document).ready(function () {

            $('#search-area').keyup(function () {
                $('#close-searches').show();
                var s = $(this).val();
                if (s.length == 0) {
                    $('#close-searches').hide();
                }
                else if (s.length > 2) {
                    load_areas(s);

                } else {
                    document.getElementById("searches").style.display = "none";
                    $('#searches ul').empty();
                    $('#loading').hide();

                }
            });


            $('[data-toggle="tooltip"]').tooltip();
            $('#itemslider').carousel({interval: 8000});
            $('#itemslider2').carousel({interval: 10000});

            $("#search-area").focusin(function () {
                var s = $(this).val();
                if (s.length > 2) {
                    $('#close-searches').show();
                    if ($('#searches ul').children().length > 0) {
                        document.getElementById("searches").style.display = "block";
                    } else {
                        load_areas(s);
                    }

                }
            });


            $('#close-searches').click(function () {
                $(this).hide();
                document.getElementById("searches").style.display = "none";
                $('#searches ul').empty();
                $('#loading').hide();
                $('#search-area').val("");

                $('#search-area').prop("disabled", false); // Element(s) are now enabled.

            });


            if ($('#search-area').val().length > 0) {
                $('#close-searches').show();
            }


        });


        function load_areas(term) {
            $('#loading').show();
            $.ajax({
                url: '{{url('get_area')}}',
                type: 'GET',
                data: {'term': term},
                dataType: 'json',
                complete: function () {
                    $('#loading').hide();
                },
                success: function (json) {
                    $('#searches ul').empty();
                    if (json.length > 0)
                        $.each(json, function (i, shop) {
                            document.getElementById("searches").style.display = "block";
                            var option_cate = ('<li><i class="fa fa-map-marker"></i><a href="{{ url('shops/') }}?city_id=' + shop.city_id + '&area_id=' + shop.id + '">' + shop.name + ' - ' + shop.city_name + ' منطقه ' + shop.area_num + '</a></li>');
                            $('#searches ul').append(option_cate);

                        });
                    else {
                        document.getElementById("searches").style.display = "block";
                        var option_cate = ('<li><i class="fa fa-map-marker"></i><a href="#">موردی یافت نشد</a></li>');
                        $('#searches ul').append(option_cate);
                    }

                }
            });
        }


    </script>

@endsection
