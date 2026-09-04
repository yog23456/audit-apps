<nav class="bg-white border-b border-gray-200/80 px-6 py-3 flex items-center justify-between shadow-[0_1px_4px_rgba(0,0,0,0.03)]">
    <!-- Left Logo & Toggle -->
    <div class="flex items-center gap-4">
        <button type="button" class="text-2xl text-[#005691] focus:outline-none flex items-center" id="sidebarToggle" aria-label="Buka menu">
            <i class="bi bi-list"></i>
        </button>
        <a href="<?= site_url('dashboard') ?>" class="flex items-center">
            <img src="<?= base_url('assets/img/logo.png') ?>" class="h-9 w-auto" alt="Rumah Ningrat">
        </a>
    </div>

    <!-- Right Leader Function & Profile Avatar -->
    <div class="ms-auto flex items-center gap-4">
        <div class="hidden sm:flex items-center gap-3 text-left">
            <div class="w-8 h-8 flex items-center justify-center text-[#005691] text-xl">
                <i class="bi bi-diagram-3"></i>
            </div>
            <div class="leading-tight">
                <div class="font-medium text-[12px] text-gray-700">Fungsi Leader: Plan, Delegasi, Monitoring,</div>
                <div class="text-[11px] text-gray-400">Controlling, Evaluasi &amp; Problem Solving</div>
            </div>
        </div>

        <span class="hidden sm:block w-px h-8 bg-gray-200"></span>

        <div class="relative">
            <img src="<?= base_url('assets/img/avatar.jpg') ?>" class="w-10 h-10 rounded-full object-cover border border-gray-200 shadow-sm cursor-pointer" alt="User Profile">
        </div>
    </div>
</nav>