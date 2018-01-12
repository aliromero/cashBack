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

    <!--promo-->
    <div class="promo-products">
        <div class="container">
            <div class="right-cover">
                <div class="cover">
                    <img src="{{ url("uploads/{$shop->logo}") }}"/>

                </div>
                <button class="button-4" data-toggle="modal" data-target="#myModal">مشاهده در نقشه</button>

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">{{ $shop->name }} در نقشه</h4>
                            </div>
                            <div class="modal-body-map">
                                <div id="map" style="height: 400px;"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="info">
                <h3>
                    {{ $shop->name }}
                </h3>
                <div class="address">
                    <i class="fa fa-map-marker"></i>
                    {{ $shop->address }}
                </div>
                @if($shop->tell != "")
                    <div class="tell">
                        <i class="fa fa-phone"></i>
                        <span>شماره تماس : {{ $shop->tell }}</span>
                    </div>
                @endif
                <div class="areas">
                    <i class="fa fa-map-pin"></i>
                    <span>منطقه های تحت پوشش : </span>


                    @foreach($shop->areas as $area)
                        <a class="area-tag"
                           href="{{ url("shops?city_id={$area->city_id}&area_id={$area->id}") }}">{{ $area->name }}</a>@if($shop->areas->last() !== $area)
                            , @endif
                    @endforeach
                </div>

                <div class="rating-products">

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


            </div>

        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}">خانه</a></li>
                    <li>
                            <a href="{{ url("products/{$shop->id}") }}">
                                {{ "فروشگاه {$shop->name}" }}
                            </a>
                    </li>
                    <li class="active">
                        {{ $product->name }}

                    </li>

                </ol>


                <div class="post-box">
                    <div class="title">
                        <h1>{{ $product->name }}</h1>
                    </div>
                    <div class="col-sm-6 col-md-5">
                        <div class="images">


                            <ul id="lightSlider">
                                @foreach($images as $image)
                                    <li data-thumb="{{ url("uploads/{$image->photo}") }}">
                                        <img src="{{ url("uploads/{$image->photo}") }}"/>
                                    </li>
                                @endforeach
                            </ul>


                        </div>

                    </div>
                    <div class="col-sm-6 col-md-7">
                        <div class="info-box">

                            <div class="post-categories">
                                <span><i class="fa fa-list"></i> دسته بندی : </span>
                                <ul>
                                    @foreach($product->categories as $category)
                                        <li>
                                            <a href="{{ url("products?category_id={$category->id}") }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="description">
                                {!! nl2br($product->description) !!}
                            </div>

                            <div class="price">
                                <?php
                                $takhfif = ($product->getDisType() == "percent") ? $product->price - ($product->price * $product->discount / 100) : $product->price - $product->discount; ?>
                                <span>
                                            @if($product->discount > 0)<strike>{{ $product->price }}</strike>@endif
                                    {{ $takhfif }} <font color="#000">تومان</font> </span>
                            </div>

                            <button class="buy-btn" data-toggle="modal" data-target="#myModal2"><i class="fa fa-shopping-basket"></i> خرید تخفیف</button>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                        aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">نحوه خرید تخفیف</h4>
                                        </div>
                                        <div class="modal-body">
                                           <p>برای استفاده از تخفیف ها ابتدا برنامه کش بک را روی گوشی خود نصب کنید سپس محصول مورد نظر را انتخاب و از فروشگاه خرید کرده و فاکتور خرید را ارسال کرده در نهایت تخفیف به حسابتان اضافه میگردد</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="tag-box">
                    <ul>
                        @foreach($product->tags as $tag)
                            <li><a href="{{ url("products?tag_id={$tag->id}") }}">{{ $tag->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
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

@section('custom_styles')
    <link rel="stylesheet" href="{{ asset("home/assets/css/lightslider.min.css") }}">
@endsection

@section('custom_scripts')
    <script type="application/javascript" src="{{ asset("home/assets/js/lightslider.js") }}"></script>
    <script>

        var slider = $('#lightSlider').lightSlider({
            gallery: true,
            item: 1,
            loop: true,
            slideMargin: 0,
            thumbItem: 5


        });
        slider.goToSlide({{ count($images) }});
    </script>


    <script>

        $("#myModal").on("shown.bs.modal", function () {
            var myLatLng = {lat: {{ $shop->latitude }}, lng: {{ $shop->longitude }}};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: myLatLng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                zoomControl: true,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                rotateControl: false,
                fullscreenControl: true


            });
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: "{{ $shop->name }}"
            });
            var currentCenter = map.getCenter();  // Get current center before resizing
            google.maps.event.trigger(map, "resize");
            map.setCenter(currentCenter); // Re-set previous center
        });

    </script>


    <script type="text/javascript"
            src="http://maps.google.com/maps/api/js?key=AIzaSyDA0rvN2kMxQfXXE6lUqXhV_4QkWtzL-xk&language=fa&region=IR"></script>



@endsection
