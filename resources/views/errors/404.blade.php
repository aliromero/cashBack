<html>
  <head>
    <title>{{ config('backpack.base.project_name') }} Error 404</title>
    <link href="{{ asset('home/assets/css/404.css') }}" rel="stylesheet">

  </head>
  <body>
    <div class="container">
      <div class="content">
        <div class="title">404</div>
        <div class="quote">صفحه مورد نظر شما یافت نشد</div>
        <div class="explanation">
          <br>
          <small>
            <?php
              $default_error_message = "<a href='".url('')."'>بازگشت به صفحه اصلی سایت</a>.";
            ?>
            {!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}
         </small>
       </div>
      </div>
    </div>
  </body>
</html>
