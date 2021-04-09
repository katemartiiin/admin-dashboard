<!DOCTYPE HTML>
<html>
<head>
  <title>@yield('title') | Admin Dashboard</title>
  @include('includes.head')
</head>
<body class="w-100 h-100">
  <div id="main">
    @yield('content')
  </div>
  <footer class="page-footer font-small">
    @include('includes.footer')
  </footer>
</body>
</html>