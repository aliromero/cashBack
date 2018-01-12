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
    <div class="promo">
        <div class="container-fluid">
            <h2>نوشته ای برای نمونه</h2>
            <h4>برای دیدن لیست فروشگاه هایی که به شما سرویس میدهند منطقه خود را وارد کنید.</h4>

            <div class="col-md-6 col-md-offset-3">
                <div class="area-search">
                    <i class="fa fa-search"></i>
                    <div class="loading-box" id="loading">
                        <i class="loading"></i>
                    </div>

                    <div class="btn-circle" data-toggle="tooltip" data-placement="right"
                         title="نمایش فروشگاه های اطراف من">
                        <i class="fa fa-map-marker"></i>
                    </div>


                    <input type="text" class="input-area-search" id="search-area"
                           placeholder="محله خود را جستحو کنید...">

                    <div class="searches" id="searches">
                        <ul>
                            {{--<li><i class="fa fa-map-marker"></i> <a href="#">تست</a></li>--}}
                        </ul>
                    </div>

                </div>

            </div>
            <div class="clearfix"></div>

            <a href="{{ url("shops") }}" class="button-2">نمایش لیست فروشگاه ها</a>

        </div>
    </div>
    <div class="container">
        <div class="col-sm-4 h-300">
            <div class="card">
                <div class="circle-card">۱</div>
                <h4> خرید از فروشگاه</h4>
                <p>این نوشته برای نمونه میباشد و هیچ گونه ارزشی را ندارد این نوشته برای نمونه میباشد و هیچ گونه ارزشی را
                    ندارد این نوشته برای نمونه میباشد و هیچ گونه ارزشی را ندارد </p>
            </div>
        </div>
        <div class="col-sm-4 h-300">
            <div class="card">
                <div class="circle-card">۲</div>
                <h4>ارسال فیش خرید</h4>
                <p>این نوشته برای نمونه میباشد و هیچ گونه ارزشی را ندارد این نوشته برای نمونه میباشد و هیچ گونه ارزشی را
                    ندارد این نوشته برای نمونه میباشد و هیچ گونه ارزشی را ندارد </p>
            </div>
        </div>
        <div class="col-sm-4 h-300">
            <div class="card">
                <div class="circle-card">۳</div>
                <h4>دریافت تخفیف</h4>
                <p>این نوشته برای نمونه میباشد و هیچ گونه ارزشی را ندارد این نوشته برای نمونه میباشد و هیچ گونه ارزشی را
                    ندارد این نوشته برای نمونه میباشد و هیچ گونه ارزشی را ندارد </p>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="slider-shops">
        <div class="title-sale"><span>فروشگاه های با بیشترین تخفیف</span></div>

        <!-- Item slider-->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="carousel carousel-showmanymoveone slide sale-shop" id="itemslider">

                        <ol class="carousel-indicators">
                            <li data-target="#itemslider" data-slide-to="0" class="active"></li>
                            <li data-target="#itemslider" data-slide-to="1"></li>
                            <li data-target="#itemslider" data-slide-to="2"></li>
                        </ol>


                        <div class="carousel-inner">

                            <div class="item active">
                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو 1شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>


                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>


                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>
                            </div>


                            <div class="item">
                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو 2شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>
                            </div>


                            <div class="item">
                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو 3شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- Item slider end-->
    </div>

    <div class="slider-shops">
        <div class="title-sale"><span>فروشگاه های پر فروش</span></div>

        <!-- Item slider-->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="carousel carousel-showmanymoveone slide sale-shop" id="itemslider2">

                        <ol class="carousel-indicators">
                            <li data-target="#itemslider2" data-slide-to="0" class="active"></li>
                            <li data-target="#itemslider2" data-slide-to="1"></li>
                            <li data-target="#itemslider2" data-slide-to="2"></li>
                        </ol>


                        <div class="carousel-inner">

                            <div class="item active">
                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو 1شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>


                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>


                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>
                            </div>


                            <div class="item">
                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو 2شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>
                            </div>


                            <div class="item">
                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو 3شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                                <div class="col-sm-4 col-md-2">
                                    <div class="cover">
                                        <img src="assets/images/j.png">
                                    </div>
                                    <h2>جانبو شعبه نیرو هوایی</h2>
                                </div>

                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- Item slider end-->
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
                var s = $(this).val();
                if (s.length > 2) {
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
                    if ($('#searches ul').children().length > 0) {
                        document.getElementById("searches").style.display = "block";
                    } else {
                        load_areas(s);
                    }

                }
            });


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
                            var option_cate = ('<li><i class="fa fa-map-marker"></i><a href="{{ url('shops/') }}?city_id='+ shop.city_id + '&area_id=' + shop.id + '">' + shop.name + ' - ' + shop.city_name + ' منطقه ' + shop.area_num + '</a></li>');
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
