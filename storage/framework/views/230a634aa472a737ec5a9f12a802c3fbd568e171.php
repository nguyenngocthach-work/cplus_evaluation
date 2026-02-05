  <!-- Sidebar Navigation -->
  <aside id="sidebar"
    class="flex h-full w-72 flex-col justify-between border-r border-[#e5e7eb] dark:border-[#2a3441] bg-white dark:bg-[#1a202c] overflow-y-auto shrink-0 transition-all duration-300 ease-in-out">
    <div class="flex flex-col gap-4 p-4">
    <div class="relative z-0">
      <!-- Toggle button floating -->
      <button
        onclick="toggleSidebar()"
        class="absolute -right-3 top-4 z-50
              bg-white rounded-full p-1 shadow
              hover:bg-gray-100 transition-none">
        <span id="toggleIcon"
          class="material-symbols-outlined text-sm">
          chevron_left
        </span>
      </button>
    </div>
      <div class="flex gap-3 items-center mb-6 sidebar-logo">
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
          data-alt="Abstract blue geometric logo"
          style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCRGjEbh3nPkDmPIsyOagergOq0nbi9OTWc8tSsj-qFYiQtpbqnauk0HvRhP9020CD1Nfm_FUqdBdVWX9ScmLEZoyV6HMAvuZnBarUwkhOKj53u3kf8m1YlGaz3utmS3VWLJbvzhBS74Y5jH9DUO49VoDwWYaySlkqyYLRgodSozdJXPpTw6zhPDxTlPRGOyNxjvmG_wKQf4XUaKUzfm3t2BL7jlHr5IoM0unMHM9VKyIKmNIYq2GVQW7J5BQRsYysdWzBur16VjPm5");'>
        </div>
        <div class="flex flex-col sidebar-text transition-all duration-300">
          <h1 class="text-[#111418] dark:text-white text-base font-bold leading-normal">Admin Console</h1>
          <p class="text-[#617589] dark:text-[#9ca3af] text-sm font-normal leading-normal">Management System</p>
        </div>
      </div>

      <?php
        $isActive = fn ($pattern) => request()->routeIs($pattern);
      ?>
      <div class="flex flex-col gap-2">
        <!-- Dashboard -->
        <a href="<?php echo e(route('admin.screen')); ?>"
          class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all
          <?php echo e($isActive('admin.screen')
              ? 'bg-primary/10 text-primary font-bold'
              : 'text-gray-500 hover:bg-gray-100 hover:text-primary'); ?>">

          <span class="material-symbols-outlined
            <?php echo e($isActive('admin.screen') ? 'text-primary' : ''); ?>">
            dashboard
          </span>
          <p class="text-sm">Dashboard</p>
        </a>
        
        <a href="<?php echo e(route('locations.screen')); ?>"
          class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all
          <?php echo e($isActive('locations.*')
              ? 'bg-primary/10 text-primary font-bold'
              : 'text-gray-500 hover:bg-gray-100 hover:text-primary'); ?>">

          <span class="material-symbols-outlined
            <?php echo e($isActive('locations.*') ? 'text-primary' : ''); ?>">
            location_on
          </span>
          <p class="text-sm">Locations</p>
        </a>

        
        <a href="<?php echo e(route('clients.screen')); ?>"
          class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all
          <?php echo e($isActive('clients.*')
              ? 'bg-primary/10 text-primary font-bold'
              : 'text-gray-500 hover:bg-gray-100 hover:text-primary'); ?>">
          <span class="material-symbols-outlined
            <?php echo e($isActive('clients.*') ? 'text-primary' : ''); ?>">
            groups
          </span>
          <p class="text-sm">Clients</p>
        </a>

        
        <a href="<?php echo e(route('criteria.screen')); ?>"
          class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all
          <?php echo e($isActive('criteria.*')
              ? 'bg-primary/10 text-primary font-bold'
              : 'text-gray-500 hover:bg-gray-100 hover:text-primary'); ?>">

          <span class="material-symbols-outlined
            <?php echo e($isActive('criteria.*') ? 'text-primary' : ''); ?>">
            rule
          </span>
          <p class="text-sm">Criteria</p>
        </a>

        
        <a href="<?php echo e(route('projects.screen')); ?>"
          class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all
          <?php echo e($isActive('projects.*')
              ? 'bg-primary/10 text-primary font-bold'
              : 'text-gray-500 hover:bg-gray-100 hover:text-primary'); ?>">

          <span class="material-symbols-outlined
            <?php echo e($isActive('projects.*') ? 'text-primary' : ''); ?>">
            work
          </span>
          <p class="text-sm">Projects</p>
        </a>
      </div>
    </div>

    <div class="p-4 border-t border-[#e5e7eb] dark:border-[#2a3441]">
      <div class="flex items-center justify-between">
        <!-- Profile info -->
        <div class="flex items-center gap-3 sidebar-text">
          <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
            data-alt="Profile picture of administrator"
            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCwRgvBtatfWXV_TgbykqA_J4k0uBXcI4k0uBXcI4o008UlYdazs4bOEfH1wg14pMcoCpjrEMCp08FF7dglAS8V9EMDV-sDx7an0CsRmBwJS47ZotsufskCJtncTyGPTOP_ScL3W_BkpUHBQJOlm8tTWkis1NdEf6ECwi0YgfaVUXCFHnx6nfZUByI8N4kFt0I8RSKo00yWTxAkkUKmiDpX8Y2NzqRAE5viPJZAisiCT_FfFr097EDmivn8QneYX-p-tL4dkNuPLqgT6rlgop1b");'>
          </div>

          <div>
            <p class="text-sm font-bold text-[#111418] dark:text-white">
              <?php echo e(Auth::user()->username ?? 'Admin'); ?>

            </p>
            <p class="text-xs text-[#617589] dark:text-[#9ca3af]">
              <?php echo e(Auth::user()->role ?? 'Admin'); ?>

            </p>
          </div>
        </div>

        <!-- Logout button -->
        <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" title="Logout" class="p-2 rounded-lg text-[#617589] hover:text-red-600 hover:bg-red-50
            dark:text-gray-400 dark:hover:text-red-400 dark:hover:bg-[#2a3441]
              transition-all">
            <span class="material-symbols-outlined !text-lg">
              logout
            </span>
          </button>
        </form>
      </div>
    </div>
  </aside>
<script>
  let isCollapsed = false;

  function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const texts = document.querySelectorAll('.sidebar-text, #sidebar p');
      const icon = document.getElementById('toggleIcon');

      isCollapsed = !isCollapsed;
      
      if (sidebar.classList.contains('w-72')) {
          // Thu nhỏ
          sidebar.classList.replace('w-72', 'w-20');
          texts.forEach(el => el.classList.add('hidden'));
          icon.textContent = 'chevron_right';
      } else {
          // Mở rộng
          sidebar.classList.replace('w-20', 'w-72');
          texts.forEach(el => el.classList.remove('hidden'));
          icon.textContent = 'chevron_left';
      }
      
  }
</script><?php /**PATH D:\react\work\evaluation1\evaluation\resources\views/layouts/sessions/sidebar/sidebar.blade.php ENDPATH**/ ?>