    <header
      class="flex items-center justify-between whitespace-nowrap border-b border-solid border-[#f0f2f4] dark:border-gray-800 bg-white dark:bg-[#111a22] px-10 py-3 sticky top-0 z-50">
      <div class="flex items-center gap-4 text-[#111418] dark:text-white">
        <div class="size-8 flex items-center justify-center text-primary">
          <span class="material-symbols-outlined !text-3xl">admin_panel_settings</span>
        </div>
        <h2 class="text-[#111418] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Admin Portal</h2>
      </div>
      <div class="flex flex-1 justify-end gap-8">
        <div class="hidden md:flex items-center gap-9">
          <a class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal hover:text-primary transition-colors"
            href="{{ route('admin.screen') }}">Dashboard</a>
          <a class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal hover:text-primary transition-colors"
            href="{{ route('locations.screen') }}">Locations</a>
          <a class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal hover:text-primary transition-colors"
            href="{{ route('clients.screen') }}">Clients</a>
          <a class="text-[#617589] dark:text-gray-400 text-sm font-medium leading-normal hover:text-primary transition-colors"
            href="{{ route('projects.screen') }}">Projects</a>
        </div>
        <div
          class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border border-[#f0f2f4] dark:border-gray-700"
          data-alt="User profile avatar showing a smiling person"
          style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBTPWaJV9tK5B8aY_Sa-rNI9PwKPLxtN9WCmmXeKTucV651VRd_QMq-Wxm5XbwJ2Ko5jfwr1ikhWa8v_d-3UKQRk4EbxDikPs0jQJFVFeFjU4E9w25kbFRqJ4LCfPyIzXRSUasrqu3JPv6h3cEoGVR7rkQtyVFZMBO574Di6SBIyWeO68ajvJ_3J2Yiyj4qJtkiSan0OYnY-SPjgC7PL0yKnJ1Bnujyhfo36g3-gPV-9itaxVPJ8ui8o0m8iQ_BP_uGuFPhup1MDUxb");'>
        </div>
      </div>
    </header>