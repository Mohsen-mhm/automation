<div id="drawer-body-scrolling"
     class="fixed top-0 left-0 z-50 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-[#6058C3] text-white w-64"
     tabindex="-1" aria-labelledby="drawer-body-scrolling-label">
    <h5 id="drawer-body-scrolling-label" class="text-base font-semibold">
        اطلاعات مکان انتخابی
    </h5>
    <button type="button" data-drawer-hide="drawer-body-scrolling" aria-controls="drawer-body-scrolling"
            class="bg-transparent hover:bg-[#7367F0] hover:text-gray-200 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center">
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
        </svg>
        <span class="sr-only">Close menu</span>
    </button>
    <div class="py-4 overflow-y-auto">
        <div id="markers-info"></div>

        <script src="./assets/js/map.js"></script>
    </div>
</div>
