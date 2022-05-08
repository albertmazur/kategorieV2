<!doctype html>
<html lang="pl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{mix("css/app.css") }}" rel='stylesheet' type='text/css'>
    <link href="{{mix("css/style.css") }}" rel='stylesheet' type='text/css'>
    <title>Kategorie</title>
  </head>
  <body>
  <div class="container">
      <div class="row">
        @include('tree')
        @include('form')
      </div>
  </div>
  <script src="{{ mix("js/app.js")}}"></script>
  <script src="{{ mix("js/script.js")}}"></script>
  </body>
</html>
