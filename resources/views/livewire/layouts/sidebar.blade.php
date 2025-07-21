<div id="detailsSidebar"
     :class="sidebarToggleDetail ? 'translate-x-0' : 'translate-x-full'"
     class="fixed left-0 top-0 z-40 h-screen w-96 transform bg-white shadow-2xl transition-transform duration-300 ease-in-out" style="z-index: 99999"
     x-show="sidebarToggleDetail"
     @click.outside="sidebarToggleDetail = false">

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4">
        <div class="flex items-center space-x-3 rtl:space-x-reverse">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500 text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">اطلاعات تفصیلی</h3>
                <p class="text-sm text-slate-500">جزئیات مکان انتخابی</p>
            </div>
        </div>
        <button
            @click="sidebarToggleDetail = false"
            class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Content --}}
    <div class="h-full overflow-y-scroll p-6">
        <div id="markers-info" class="space-y-6">
            {{-- Content will be populated by JavaScript --}}
            <div class="flex items-center justify-center h-64 text-slate-400">
                <div class="text-center">
                    <svg class="h-16 w-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-lg font-medium">انتخاب کنید</p>
                    <p class="text-sm">برای مشاهده جزئیات، روی نقشه کلیک کنید</p>
                </div>
            </div>
        </div>
    </div>
</div>
