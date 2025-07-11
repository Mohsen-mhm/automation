<!-- Mobile Sidebar Toggle -->
<div class="md:hidden z-50">
    <button id="sidebarToggle"
            class="group relative bg-white shadow-lg hover:shadow-xl text-gray-800 p-3 rounded-2xl focus:outline-none transition-all duration-300 hover:scale-105 border border-gray-200">

        <!-- Hamburger Icon -->
        <div class="relative w-6 h-6">
            <span
                class="hamburger-line absolute left-0 top-1 w-6 h-0.5 bg-current transition-all duration-300 ease-in-out transform group-hover:bg-emerald-600"></span>
            <span
                class="hamburger-line absolute left-0 top-3 w-6 h-0.5 bg-current transition-all duration-300 ease-in-out transform group-hover:bg-emerald-600"></span>
            <span
                class="hamburger-line absolute left-0 top-5 w-6 h-0.5 bg-current transition-all duration-300 ease-in-out transform group-hover:bg-emerald-600"></span>
        </div>

        <!-- Tooltip -->
        <div
            class="absolute left-full ml-3 top-1/2 transform -translate-y-1/2 bg-gray-900 text-white text-sm px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap pointer-events-none z-10">
            منوی اصلی
            <div
                class="absolute left-0 top-1/2 transform translate-x-1 -translate-y-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
        </div>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const hamburgerLines = document.querySelectorAll('.hamburger-line');

        let isOpen = false;

        function toggleSidebar() {
            isOpen = !isOpen;

            if (isOpen) {
                // Open sidebar
                sidebar.classList.remove('translate-x-full');
                sidebar.classList.add('translate-x-0');
                sidebarOverlay.classList.remove('opacity-0', 'invisible');
                sidebarOverlay.classList.add('opacity-100', 'visible');
                document.body.style.overflow = 'hidden';

                // Animate hamburger to X
                hamburgerLines[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                hamburgerLines[1].style.opacity = '0';
                hamburgerLines[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';

            } else {
                // Close sidebar
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('translate-x-full');
                sidebarOverlay.classList.remove('opacity-100', 'visible');
                sidebarOverlay.classList.add('opacity-0', 'invisible');
                document.body.style.overflow = '';

                // Animate X back to hamburger
                hamburgerLines[0].style.transform = 'rotate(0) translate(0, 0)';
                hamburgerLines[1].style.opacity = '1';
                hamburgerLines[2].style.transform = 'rotate(0) translate(0, 0)';
            }
        }

        // Toggle button click
        sidebarToggle.addEventListener('click', toggleSidebar);

        // Overlay click to close
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function () {
                if (isOpen) {
                    toggleSidebar();
                }
            });
        }

        // Close sidebar when clicking on a menu link (mobile)
        sidebar.addEventListener('click', function (e) {
            if (e.target.closest('a') && isOpen) {
                setTimeout(() => {
                    toggleSidebar();
                }, 150);
            }
        });

        // Close sidebar on escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && isOpen) {
                toggleSidebar();
            }
        });

        // Handle window resize
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768 && isOpen) {
                // Reset mobile sidebar when switching to desktop
                isOpen = false;
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('translate-x-full');
                sidebarOverlay.classList.remove('opacity-100', 'visible');
                sidebarOverlay.classList.add('opacity-0', 'invisible');
                document.body.style.overflow = '';

                // Reset hamburger animation
                hamburgerLines[0].style.transform = 'rotate(0) translate(0, 0)';
                hamburgerLines[1].style.opacity = '1';
                hamburgerLines[2].style.transform = 'rotate(0) translate(0, 0)';
            }
        });

        // Add smooth scroll behavior to sidebar
        if (sidebar) {
            sidebar.style.scrollBehavior = 'smooth';
        }

        // Add ripple effect to toggle button
        sidebarToggle.addEventListener('click', function (e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');

            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
</script>

<style>
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(16, 185, 129, 0.3);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
</style>
