@extends('layouts.app')

@section('title', 'مدیریت دسترسی‌ها')

@section('content')
    <div class="space-y-8">
        <!-- Toast Container -->
        <div id="toastContainer" class="fixed bottom-5 left-5 z-50 space-y-3" style="z-index: 999999999 !important;"></div>

        <!-- Page Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center ml-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 16 20">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11.5 8V4.5a3.5 3.5 0 1 0-7 0V8M8 12v3M2 8h12a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1Z"/>
                            </svg>
                        </div>
                        مدیریت دسترسی‌ها
                    </h1>
                    <p class="text-gray-600 mt-1">مشاهده و مدیریت دسترسی‌های سیستم</p>
                </div>
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <!-- Export Button -->
                    <button onclick="exportData()"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        خروجی Excel
                    </button>
                    <!-- Refresh Button -->
                    <button onclick="refreshTable()"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        بروزرسانی
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm">کل دسترسی‌ها</p>
                        <p class="text-2xl font-bold" id="totalPermissions">-</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 16 20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11.5 8V4.5a3.5 3.5 0 1 0-7 0V8M8 12v3M2 8h12a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1Z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">دسترسی‌های سیستمی</p>
                        <p class="text-2xl font-bold" id="systemPermissions">-</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm">دسترسی‌های کاربری</p>
                        <p class="text-2xl font-bold" id="userPermissions">-</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="p-6 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <h2 class="text-lg font-semibold text-gray-900">لیست دسترسی‌ها</h2>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <span id="permissionCount">-</span> دسترسی
                        </span>
                    </div>

                    <!-- Search and Filters -->
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <!-- Category Filter -->
                        <select id="categoryFilter"
                                class="border border-gray-300 rounded-lg px-3 py-2 bg-white text-gray-900 text-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="">همه دسته‌ها</option>
                            <option value="system">سیستمی</option>
                            <option value="user">کاربری</option>
                            <option value="admin">مدیریتی</option>
                        </select>

                        <!-- Search -->
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="search" id="searchInput"
                                   class="block w-64 pr-10 pl-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200"
                                   placeholder="جستجو در دسترسی‌ها...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modern Table -->
            <div class="overflow-x-auto">
                <table id="permissionsTable" class="w-full">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            ردیف
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            عنوان
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            نام سیستمی
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            دسته‌بندی
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            تاریخ ایجاد
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <!-- Data will be loaded via DataTables -->
                    </tbody>
                </table>
            </div>

            <!-- Enhanced Table Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse text-sm text-gray-600">
                        <span>نمایش</span>
                        <select id="pageLength"
                                class="border border-gray-300 rounded-lg px-3 py-1 bg-white text-gray-900">
                            <option value="10">10</option>
                            <option value="25" selected>25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span>ردیف در هر صفحه</span>
                    </div>

                    <div id="tableInfo" class="text-sm text-gray-600">
                        <!-- Will be populated by DataTables -->
                    </div>

                    <div id="tablePagination" class="flex items-center space-x-2 rtl:space-x-reverse">
                        <!-- Will be populated by DataTables -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Permission Details Modal -->
        <div id="detailsModal"
             class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div
                class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
                <!-- Modal Header -->
                <div
                    class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-yellow-500 to-orange-500">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">جزئیات دسترسی</h3>
                            <p class="text-white/80 text-sm">اطلاعات کامل دسترسی</p>
                        </div>
                    </div>
                    <button onclick="closeDetailsModal()"
                            class="text-white/80 hover:text-white transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-140px)]">
                    <div id="permissionDetails" class="space-y-6">
                        <!-- Permission details will be populated here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <style>
        /* Custom DataTable Styles */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            display: none;
        }

        #permissionsTable tbody tr {
            transition: all 0.2s ease;
        }

        #permissionsTable tbody tr:hover {
            background-color: rgba(245, 158, 11, 0.05);
            transform: translateX(-2px);
        }

        /* Category badges */
        .category-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            line-height: 1;
        }

        .category-system {
            background-color: rgba(34, 197, 94, 0.1);
            color: rgb(21, 128, 61);
        }

        .category-user {
            background-color: rgba(168, 85, 247, 0.1);
            color: rgb(124, 58, 237);
        }

        .category-admin {
            background-color: rgba(239, 68, 68, 0.1);
            color: rgb(185, 28, 28);
        }

        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Detail card styles */
        .detail-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 1.5rem;
        }

        .detail-label {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            color: #1e293b;
            font-weight: 600;
        }

        /* Clickable titles */
        .permission-title {
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .permission-title:hover {
            color: #f59e0b;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        let permissionsTable;

        $(document).ready(function () {
            initializeDataTable();
            bindEventHandlers();
            updateStats();
        });

        function initializeDataTable() {
            permissionsTable = $('#permissionsTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ordering: false,
                ajax: {
                    url: '{{ route("panel.permissions.data") }}',
                    type: 'GET',
                    data: function (d) {
                        d.search.value = $('#searchInput').val();
                        d.category = $('#categoryFilter').val();
                    }
                },
                columns: [
                    {
                        data: 0,
                        name: 'id',
                        render: function (data, type, row, meta) {
                            return `<span class="inline-flex items-center justify-center w-8 h-8 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-full">${data}</span>`;
                        }
                    },
                    {
                        data: 1,
                        name: 'title',
                        render: function (data, type, row) {
                            return `<div class="permission-title font-medium text-gray-900" onclick="showPermissionDetails(${row[5]})">${data}</div>`;
                        }
                    },
                    {
                        data: 2,
                        name: 'name',
                        render: function (data, type, row) {
                            return `<code class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">${data}</code>`;
                        }
                    },
                    {
                        data: 3,
                        name: 'category',
                        className: 'text-center',
                        render: function (data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 4,
                        name: 'created_at',
                        className: 'text-center',
                        render: function (data, type, row) {
                            return `<span class="text-sm text-gray-600">${data}</span>`;
                        }
                    }
                ],
                pageLength: 25,
                language: {
                    processing: "در حال پردازش...",
                    lengthMenu: "نمایش _MENU_ ردیف",
                    info: "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
                    infoEmpty: "نمایش 0 تا 0 از 0 ردیف",
                    infoFiltered: "(فیلتر شده از _MAX_ ردیف)",
                    search: "جستجو:",
                    paginate: {
                        first: "اول",
                        previous: "قبلی",
                        next: "بعدی",
                        last: "آخر"
                    },
                    emptyTable: "هیچ داده‌ای در جدول وجود ندارد",
                    zeroRecords: "هیچ رکوردی یافت نشد"
                },
                dom: 'rt',
                drawCallback: function (settings) {
                    updateTableInfo(settings);
                    updatePagination(settings);
                },
                initComplete: function () {
                    updateStats();
                }
            });
        }

        function bindEventHandlers() {
            // Custom search
            $('#searchInput').on('keyup', debounce(function () {
                permissionsTable.draw();
            }, 300));

            // Category filter
            $('#categoryFilter').on('change', function () {
                permissionsTable.draw();
            });

            // Page length change
            $('#pageLength').on('change', function () {
                permissionsTable.page.len($(this).val()).draw();
            });

            // Modal close handlers
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeDetailsModal();
                }
            });

            $('#detailsModal').on('click', function (e) {
                if (e.target === this) closeDetailsModal();
            });
        }

        function updateTableInfo(settings) {
            const info = permissionsTable.page.info();
            $('#tableInfo').html(`نمایش ${info.start + 1} تا ${info.end} از ${info.recordsTotal} ردیف`);
            $('#permissionCount').text(info.recordsTotal);
        }

        function updatePagination(settings) {
            const info = permissionsTable.page.info();
            let paginationHtml = '';

            if (info.pages > 1) {
                // Previous button
                paginationHtml += `<button onclick="changePage('previous')" ${info.page === 0 ? 'disabled' : ''}
                    class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:text-gray-700 transition-colors duration-200 ${info.page === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50'}">
                    قبلی
                </button>`;

                // Page numbers
                const startPage = Math.max(0, info.page - 2);
                const endPage = Math.min(info.pages - 1, info.page + 2);

                for (let i = startPage; i <= endPage; i++) {
                    paginationHtml += `<button onclick="changePage(${i})"
                        class="px-3 py-2 text-sm font-medium transition-colors duration-200 ${i === info.page ? 'text-yellow-600 bg-yellow-50 border-yellow-300' : 'text-gray-500 bg-white border-gray-300 hover:text-gray-700 hover:bg-gray-50'} border">
                        ${i + 1}
                    </button>`;
                }

                // Next button
                paginationHtml += `<button onclick="changePage('next')" ${info.page === info.pages - 1 ? 'disabled' : ''}
                    class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:text-gray-700 transition-colors duration-200 ${info.page === info.pages - 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50'}">
                    بعدی
                </button>`;
            }

            $('#tablePagination').html(paginationHtml);
        }

        function changePage(page) {
            if (page === 'previous') {
                permissionsTable.page('previous').draw('page');
            } else if (page === 'next') {
                permissionsTable.page('next').draw('page');
            } else {
                permissionsTable.page(page).draw('page');
            }
        }

        function updateStats() {
            $.get('{{ route("panel.permissions.data") }}', {length: -1})
                .done(function (response) {
                    $('#totalPermissions').text(response.recordsTotal || 0);

                    // Calculate category stats (you can enhance this with actual API call)
                    const total = response.recordsTotal || 0;
                    $('#systemPermissions').text(Math.floor(total * 0.4));
                    $('#userPermissions').text(Math.floor(total * 0.6));
                })
                .fail(function () {
                    $('#totalPermissions').text('خطا');
                    $('#systemPermissions').text('خطا');
                    $('#userPermissions').text('خطا');
                });
        }

        function refreshTable() {
            permissionsTable.ajax.reload(null, false);
            updateStats();
            showToast('جدول با موفقیت بروزرسانی شد', 'success');
        }

        function exportData() {
            window.location.href = '{{ route("panel.permissions.export") }}?format=excel';
            showToast('درحال تهیه فایل Excel...', 'info');
        }

        function showPermissionDetails(permissionId) {
            // Show loading state
            $('#permissionDetails').html(`
                <div class="flex items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-yellow-600"></div>
                    <span class="mr-3 text-gray-600">در حال بارگذاری...</span>
                </div>
            `);
            $('#detailsModal').removeClass('hidden').addClass('flex');

            $.get(`{{ route('panel.permissions.show', '') }}/${permissionId}`)
                .done(function (response) {
                    if (response.success) {
                        populateDetailsModal(response.permission);
                    } else {
                        $('#permissionDetails').html(`
                            <div class="text-center py-12">
                                <svg class="w-12 h-12 text-red-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-gray-500">خطا در بارگذاری جزئیات دسترسی</p>
                                    <button onclick="showPermissionDetails(${permissionId})" class="mt-4 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors duration-200">
                                        تلاش مجدد
                                    </button>
                                </div>
                            `);
                        showToast('خطا در بارگذاری جزئیات دسترسی', 'error');
                    }
                });

            function populateDetailsModal(permission) {
                const categoryMap = {
                    'سیستمی': {text: 'سیستمی', class: 'category-system'},
                    'کاربری': {text: 'کاربری', class: 'category-user'},
                    'مدیریتی': {text: 'مدیریتی', class: 'category-admin'}
                };

                const category = categoryMap[permission.category] || {text: 'نامشخص', class: 'category-system'};

                const detailsHtml = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="detail-card">
                        <div class="detail-label">شناسه</div>
                        <div class="detail-value">#${permission.id}</div>
                    </div>

                    <div class="detail-card">
                        <div class="detail-label">عنوان</div>
                        <div class="detail-value">${permission.title}</div>
                    </div>

                    <div class="detail-card">
                        <div class="detail-label">نام سیستمی</div>
                        <div class="detail-value">
                            <code class="px-2 py-1 text-sm bg-gray-200 text-gray-800 rounded">${permission.name}</code>
                        </div>
                    </div>

                    <div class="detail-card">
                        <div class="detail-label">دسته‌بندی</div>
                        <div class="detail-value">
                            <span class="category-badge ${category.class}">${category.text}</span>
                        </div>
                    </div>

                    <div class="detail-card">
                        <div class="detail-label">محافظ</div>
                        <div class="detail-value">${permission.guard_name}</div>
                    </div>

                    <div class="detail-card">
                        <div class="detail-label">تعداد نقش‌های مرتبط</div>
                        <div class="detail-value">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${permission.roles_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                                ${permission.roles_count} نقش
                            </span>
                        </div>
                    </div>
                </div>

                <div class="detail-card mt-6">
                    <div class="detail-label">توضیحات</div>
                    <div class="detail-value">${permission.description || 'توضیحی ثبت نشده است.'}</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div class="detail-card">
                        <div class="detail-label">تاریخ ایجاد</div>
                        <div class="detail-value">${permission.created_at}</div>
                    </div>

                    <div class="detail-card">
                        <div class="detail-label">آخرین بروزرسانی</div>
                        <div class="detail-value">${permission.updated_at}</div>
                    </div>
                </div>
            `;

                $('#permissionDetails').html(detailsHtml);
            }

            function closeDetailsModal() {
                $('#detailsModal').removeClass('flex').addClass('hidden');
                $('#permissionDetails').empty();
            }

            function showToast(message, type = 'info') {
                const toastId = 'toast_' + Date.now();
                const iconMap = {
                    success: '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>',
                    error: '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>',
                    info: '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>'
                };

                const colorMap = {
                    success: 'text-green-500 bg-green-100',
                    error: 'text-red-500 bg-red-100',
                    info: 'text-blue-500 bg-blue-100'
                };

                const borderMap = {
                    success: 'border-green-500',
                    error: 'border-red-500',
                    info: 'border-blue-500'
                };

                const toast = $(`
                <div id="${toastId}" class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-lg transform translate-x-full transition-all duration-300 border-l-4 ${borderMap[type]}" role="alert">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${colorMap[type]}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            ${iconMap[type]}
                        </svg>
                    </div>
                    <div class="mr-3 text-sm font-normal">${message}</div>
                    <button type="button" onclick="removeToast('${toastId}')" class="mr-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 transition-colors duration-200">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `);

                // Create toast container if it doesn't exist
                if ($('#toastContainer').length === 0) {
                    $('body').append('<div id="toastContainer" class="fixed bottom-5 left-5 z-50 space-y-3"></div>');
                }

                $('#toastContainer').append(toast);

                setTimeout(() => toast.removeClass('translate-x-full'), 100);
                setTimeout(() => removeToast(toastId), 5000);
            }

            function removeToast(toastId) {
                const toast = $(`#${toastId}`);
                toast.addClass('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }

            // Utility function for debouncing
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Add CSRF token to meta if not present
            if (!$('meta[name="csrf-token"]').attr('content')) {
                $('head').append('<meta name="csrf-token" content="{{ csrf_token() }}">');
            }
        }
    </script>
@endpush
