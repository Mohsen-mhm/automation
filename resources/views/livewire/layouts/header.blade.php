<header class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-slate-200/50 shadow-sm z-50">
    <div class="mx-auto max-w-screen-2xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            {{-- Mobile Menu Button --}}
            <button
                class="lg:hidden p-2 rounded-xl bg-slate-100 hover:bg-slate-200 transition-colors"
                @click.stop="sidebarToggle = !sidebarToggle">
                <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Logo and Title --}}
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse group">
                    <div class="p-2 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 group-hover:from-emerald-600 group-hover:to-emerald-700 transition-all duration-200 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">
                            سامانه متمرکز گلخانه‌های برخط کشور
                        </h1>
                    </div>
                </a>
            </div>

            {{-- Actions (if needed) --}}
            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                {{-- Add any header actions here --}}
            </div>
        </div>
    </div>
</header>
