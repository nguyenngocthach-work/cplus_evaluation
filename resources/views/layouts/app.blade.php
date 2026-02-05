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

<body class="bg-background-light dark:bg-background-dark font-display text-[#111418] dark:text-white">

  {{-- Header --}}
  @include('layouts.sessions.header.top')
  <div class="flex h-[calc(100vh-4rem)] overflow-hidden">

  {{-- Sidebar --}}
    @include('layouts.sessions.sidebar.sidebar')
    <main class="flex-1 overflow-y-auto">
      @yield('content')
    </main>
  </div>
  
  {{-- Global scripts --}}
  @include('layouts.sessions.scripts')

  {{-- Page specific scripts --}}
  @stack('styles')
</body>

</html>