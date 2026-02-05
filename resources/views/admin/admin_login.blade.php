@extends('layouts.auth')
@section('title', 'Admin Login')
@section('content')
<div class="min-h-screen flex bg-[#f8fafc] dark:bg-[#111827]">

  <!-- Left Branding -->
  <div
    class="hidden lg:flex w-1/2 bg-white dark:bg-[#1a202c] border-r border-[#e5e7eb] dark:border-[#2a3441] flex-col justify-center px-16">
    <div class="flex items-center gap-4 mb-6">
      <div class="bg-center bg-no-repeat bg-cover rounded-full size-12"
        style='background-image:url("https://lh3.googleusercontent.com/aida-public/AB6AXuCRGjEbh3nPkDmPIsyOagergOq0nbi9OTWc8tSsj-qFYiQtpbqnauk0HvRhP9020CD1Nfm_FUqdBdVWX9ScmLEZoyV6HMAvuZnBarUwkhOKj53u3kf8m1YlGaz3utmS3VWLJbvzhBS74Y5jH9DUO49VoDwWYaySlkqyYLRgodSozdJXPpTw6zhPDxTlPRGOyNxjvmG_wKQf4XUaKUzfm3t2BL7jlHr5IoM0unMHM9VKyIKmNIYq2GVQW7J5BQRsYysdWzBur16VjPm5");'>
      </div>
      <div>
        <h1 class="text-2xl font-bold text-[#111418] dark:text-white">
          Admin Console
        </h1>
        <p class="text-sm text-[#617589] dark:text-[#9ca3af]">
          Management System
        </p>
      </div>
    </div>

    <p class="text-[#617589] dark:text-[#9ca3af] max-w-md leading-relaxed">
      Secure administration panel to manage efficiently.
    </p>
  </div>

  <!-- Login Form -->
  <div class="flex flex-1 items-center justify-center px-6">
    <div
      class="w-full max-w-md bg-white dark:bg-[#1a202c] rounded-xl shadow-sm border border-[#e5e7eb] dark:border-[#2a3441] p-8">

      <h2 class="text-2xl font-bold text-[#111418] dark:text-white mb-2">
        Welcome back
      </h2>
      <p class="text-sm text-[#617589] dark:text-[#9ca3af] mb-6">
        Please sign in to continue
      </p>

      <!-- Error -->
      @if ($errors->any())
      <div class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 px-4 py-3 text-sm">
        {{ $errors->first() }}
      </div>
      @endif

      <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
          <label class="block text-sm font-medium text-[#111418] dark:text-white mb-1">
            User Name
          </label>
          <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#617589]">
              mail
            </span>
            <input type="text" name="username" value="{{ old('username') }}" required autofocus
              class="w-full pl-10 pr-4 py-2 rounded-lg bg-[#f0f2f4] dark:bg-[#2d3748] border-none text-sm text-[#111418] dark:text-white focus:ring-2 focus:ring-primary"
              placeholder="admin@example.com">
          </div>
        </div>

        <!-- Password -->
        <div>
          <label class="block text-sm font-medium text-[#111418] dark:text-white mb-1">
            Password
          </label>
          <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#617589]">
              lock
            </span>
            <input type="password" name="password" required
              class="w-full pl-10 pr-4 py-2 rounded-lg bg-[#f0f2f4] dark:bg-[#2d3748] border-none text-sm text-[#111418] dark:text-white focus:ring-2 focus:ring-primary"
              placeholder="••••••••">
          </div>
        </div>

        <!-- Remember -->
        <div class="flex items-center justify-between">
          <label class="flex items-center gap-2 text-sm text-[#617589] dark:text-[#9ca3af]">
            <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary focus:ring-primary">
            Remember me
          </label>

          <a href="#" class="text-sm font-medium text-primary hover:text-blue-700">
            Forgot password?
          </a>
        </div>

        <!-- Submit -->
        <button type="submit"
          class="w-full bg-primary text-white py-2.5 rounded-lg font-bold text-sm hover:bg-blue-600 transition flex items-center justify-center gap-2">
          <span class="material-symbols-outlined text-sm">login</span>
          Sign In
        </button>
      </form>

      <p class="mt-6 text-center text-xs text-[#617589] dark:text-[#9ca3af]">
        © 2023 Admin Console System
      </p>
    </div>
  </div>
</div>
@endsection