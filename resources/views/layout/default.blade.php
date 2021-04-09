<!DOCTYPE HTML>
<html>
<head>
  <title>@yield('title') | Admin Dashboard</title>
  @include('includes.head')
</head>
<body class="w-100 h-100">
  <header class="page-header">
    @include('includes.header')
  </header>
  <div id="app">
    @yield('content')
  </div>
  <footer class="page-footer font-small">
    @include('includes.footer')
  </footer>
</body>
<script src="{{ mix('js/app.js')}}"></script>
</html>