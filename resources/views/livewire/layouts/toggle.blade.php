<div class="fixed left-4 top-4 z-30">
    <button id="sidebarToggleDetail"
            @click="sidebarToggleDetail = !sidebarToggleDetail"
            class="group flex h-12 w-12 items-center justify-center rounded-xl bg-white shadow-lg transition-all duration-200 hover:bg-emerald-50 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
            :class="{ 'bg-emerald-50 shadow-xl': sidebarToggleDetail }">
        <svg class="h-6 w-6 text-slate-600 transition-colors group-hover:text-emerald-600"
             :class="{ 'text-emerald-600': sidebarToggleDetail }"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  x-show="!sidebarToggleDetail"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  x-show="sidebarToggleDetail"
                  d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    {{-- Tooltip --}}
    <div class="absolute left-full top-1/2 ml-3 -translate-y-1/2 transform opacity-0 transition-opacity group-hover:opacity-100"
         :class="{ 'hidden': sidebarToggleDetail }">
        <div class="rounded-lg bg-slate-800 px-3 py-2 text-sm text-white shadow-lg">
            اطلاعات تفصیلی
            <div class="absolute right-full top-1/2 -translate-y-1/2 transform">
                <div class="h-2 w-2 rotate-45 bg-slate-800"></div>
            </div>
        </div>
    </div>
</div>
