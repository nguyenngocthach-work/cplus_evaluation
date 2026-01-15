<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>@yield('title', 'Auth')</title>

  {{-- Global styles --}}
  @include('layouts.sessions.styles')

  {{-- Page specific styles --}}
  @stack('styles')
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white">


  @yield('content')

  {{-- Global scripts --}}
  @include('layouts.sessions.scripts')

  {{-- Page specific scripts --}}
  @stack('scripts')
</body>

</html>