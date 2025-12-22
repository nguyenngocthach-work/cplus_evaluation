<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>@yield('title', 'App')</title>

  {{-- Global styles --}}
  @include('layouts.sessions.styles')
  {{-- Global scripts --}}
  @include('layouts.sessions.scripts')
  {{-- Page specific styles --}}
  @stack('styles')
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white overflow-x-hidden">
  @yield('content')

  {{-- Global scripts --}}
  @include('layouts.sessions.scripts')

  {{-- Page specific scripts --}}
  @stack('styles')
</body>

</html>