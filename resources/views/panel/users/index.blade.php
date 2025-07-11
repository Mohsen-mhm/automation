@extends('layouts.app')

@section('title', 'مدیریت کاربران')

@section('content')
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center ml-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-width="2"
                                      d="M16 19h4c.6 0 1-.4 1-1v-1a3 3 0 0 0-3-3h-2m-2.2-4A3 3 0 0 0 19 8a3 3 0 0 0-5.2-2M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1c0 .6-.4 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </div>
                        مدیریت کاربران
                    </h1>
                    <p class="text-gray-600 mt-1">مدیریت کاربران و دسترسی‌های سیستم</p>
                </div>
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <!-- Export Button -->
                    <div class="relative">
                        <button onclick="toggleExportDropdown()"
                                class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            صادرات
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Export Dropdown -->
                        <div id="exportDropdown"
                             class="hidden absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 z-50">
                            <div class="py-2">
                                <button onclick="exportData('csv')"
                                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    <svg class="w-4 h-4 ml-3 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                    </svg>
                                    CSV فایل
                                </button>
                                <button onclick="exportData('html')"
                                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    <svg class="w-4 h-4 ml-3 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                    </svg>
                                    Excel جدول
                                </button>
                            </div>
                        </div>
                    </div>
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">کل کاربران</p>
                        <p class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-width="2"
                                  d="M16 19h4c.6 0 1-.4 1-1v-1a3 3 0 0 0-3-3h-2m-2.2-4A3 3 0 0 0 19 8a3 3 0 0 0-5.2-2M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1c0 .6-.4 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm">کاربران فعال</p>
                        <p class="text-2xl font-bold">{{ $stats['active'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm">کاربران غیرفعال</p>
                        <p class="text-2xl font-bold">{{ $stats['inactive'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm">مدیران سیستم</p>
                        <p class="text-2xl font-bold">{{ $stats['admin'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m5.586-4H17M7 7h-.586L9 4.414V7a1 1 0 01-1 1zm6-3V1.5a1.5 1.5 0 011.5 1.5V4h4a1 1 0 011 1v8a1 1 0 01-1 1H6a1 1 0 01-1-1V5a1 1 0 011-1h7z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="p-6 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <h2 class="text-lg font-semibold text-gray-900">لیست کاربران</h2>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <span id="userCount">-</span> کاربر
                        </span>
                    </div>

                    <!-- Filters -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full lg:w-auto">
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
                                   class="block w-64 pr-10 pl-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                   placeholder="جستجو در کاربران...">
                        </div>

                        <!-- Status Filter -->
                        <select id="statusFilter"
                                class="border border-gray-300 rounded-xl px-4 py-2.5 bg-white text-gray-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value="">همه وضعیت‌ها</option>
                            <option value="1">فعال</option>
                            <option value="0">غیرفعال</option>
                        </select>

                        <!-- Role Filter -->
                        <select id="roleFilter"
                                class="border border-gray-300 rounded-xl px-4 py-2.5 bg-white text-gray-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value="">همه نقش‌ها</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Modern Table -->
            <div class="overflow-x-auto">
                <table id="usersTable" class="w-full">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            ردیف
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            نام
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            کد ملی
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            شماره تلفن
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            وضعیت
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            نقش
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            تاریخ عضویت
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            عملیات
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
    </div>

    @can(\App\Models\User::USER_EDIT)
        <!-- Enhanced Edit Modal -->
        <div id="editModal"
             class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div
                class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-hidden">
                <!-- Modal Header -->
                <div
                    class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-blue-600">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">ویرایش کاربر</h3>
                    </div>
                    <button onclick="closeEditModal()"
                            class="text-white/80 hover:text-white transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-140px)]" id="modalBody">
                    <!-- Dynamic content will be loaded here -->
                    <div class="flex items-center justify-center py-12">
                        <div class="text-center">
                            <div
                                class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                            <p class="text-gray-500">در حال بارگذاری...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

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

        #usersTable tbody tr {
            transition: all 0.2s ease;
        }

        #usersTable tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.05);
            transform: translateX(-2px);
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

        /* Loading animation */
        .table-loading {
            position: relative;
        }

        .table-loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        /* Modal animations */
        #editModal {
            backdrop-filter: blur(8px);
        }

        #editModal > div {
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        let usersTable;
        let currentUserId = null;

        $(document).ready(function () {
            initializeDataTable();
            bindEventHandlers();
        });

        function initializeDataTable() {
            usersTable = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ordering: false,
                searching: false,
                lengthChange: false,
                ajax: {
                    url: '{{ route("panel.users.data") }}',
                    type: 'GET',
                    data: function (d) {
                        d.search = {
                            value: $('#searchInput').val() || '',
                            regex: false
                        };
                        d.status = $('#statusFilter').val() || '';
                        d.role = $('#roleFilter').val() || '';
                        return d;
                    },
                    error: function (xhr, error, code) {
                        console.error('DataTable AJAX error:', error);
                        showToast('خطا در بارگذاری اطلاعات', 'error');
                    }
                },
                columns: [
                    {
                        data: 0,
                        name: 'id',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return `<span class="inline-flex items-center justify-center w-8 h-8 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">${data}</span>`;
                        }
                    },
                    {
                        data: 1,
                        name: 'name',
                        orderable: false,
                        render: function (data, type, row) {
                            return `<div class="font-medium text-gray-900">${data}</div>`;
                        }
                    },
                    {
                        data: 2,
                        name: 'national_id',
                        orderable: false,
                        render: function (data, type, row) {
                            return `<div class="font-mono text-gray-700">${data}</div>`;
                        }
                    },
                    {
                        data: 3,
                        name: 'phone_number',
                        orderable: false,
                        render: function (data, type, row) {
                            return `<div class="font-mono text-gray-700" dir="ltr">${data}</div>`;
                        }
                    },
                    {
                        data: 4,
                        name: 'status',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function (data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 5,
                        name: 'roles',
                        orderable: false,
                        render: function (data, type, row) {
                            return `<div class="text-sm text-gray-700">${data}</div>`;
                        }
                    },
                    {
                        data: 6,
                        name: 'created_at',
                        orderable: false,
                        render: function (data, type, row) {
                            return `<div class="text-sm text-gray-700">${data}</div>`;
                        }
                    },
                    {
                        data: 7,
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function (data, type, row) {
                            return data;
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
                    emptyTable: "هیچ کاربری یافت نشد",
                    zeroRecords: "هیچ رکوردی یافت نشد"
                },
                dom: 'rt',
                drawCallback: function (settings) {
                    bindActionButtons();
                    updateTableInfo(settings);
                    updatePagination(settings);
                },
                error: function (xhr, error, code) {
                    console.error('DataTable error:', error);
                    showToast('خطا در بارگذاری جدول', 'error');
                }
            });
        }

        function bindEventHandlers() {
            // Custom search with debouncing
            $('#searchInput').on('keyup', debounce(function () {
                usersTable.draw();
            }, 300));

            // Filters
            $('#statusFilter, #roleFilter').on('change', function () {
                usersTable.draw();
            });

            // Page length change
            $('#pageLength').on('change', function () {
                const newLength = parseInt($(this).val());
                usersTable.page.len(newLength).draw();
            });

            // Modal close handlers
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') closeEditModal();
            });

            $('#editModal').on('click', function (e) {
                if (e.target === this) closeEditModal();
            });
        }

        function bindActionButtons() {
            // Edit buttons
            $('.btn-edit').off('click').on('click', function () {
                const userId = $(this).data('user-id');
                editUser(userId);
            });

            // Status toggle buttons
            $('.btn-toggle-status').off('click').on('click', function () {
                const userId = $(this).data('user-id');
                const currentStatus = $(this).data('current-status');
                toggleUserStatus(userId, currentStatus);
            });
        }

        function updateTableInfo(settings) {
            const info = usersTable.page.info();

            if (info.recordsTotal > 0) {
                $('#tableInfo').html(`نمایش ${info.start + 1} تا ${info.end} از ${info.recordsTotal} ردیف`);
                $('#userCount').text(info.recordsTotal);
            } else {
                $('#tableInfo').html('هیچ رکوردی یافت نشد');
                $('#userCount').text('0');
            }
        }

        function updatePagination(settings) {
            const info = usersTable.page.info();
            let paginationHtml = '';

            if (info.pages > 1) {
                // Previous button
                const prevDisabled = info.page === 0;
                paginationHtml += `<button type="button" onclick="${!prevDisabled ? 'goToPage(' + (info.page - 1) + ')' : 'return false;'}" ${prevDisabled ? 'disabled' : ''}
                    class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-lg transition-colors duration-200 ${prevDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50 hover:text-gray-700'}">
                    قبلی
                </button>`;

                // Page numbers
                const startPage = Math.max(0, info.page - 2);
                const endPage = Math.min(info.pages - 1, info.page + 2);

                for (let i = startPage; i <= endPage; i++) {
                    const isActive = i === info.page;
                    paginationHtml += `<button type="button" onclick="goToPage(${i})"
                        class="px-3 py-2 text-sm font-medium transition-colors duration-200 border ${isActive ? 'text-blue-600 bg-blue-50 border-blue-300' : 'text-gray-500 bg-white border-gray-300 hover:text-gray-700 hover:bg-gray-50'}">
                        ${i + 1}
                    </button>`;
                }

                // Next button
                const nextDisabled = info.page === info.pages - 1;
                paginationHtml += `<button type="button" onclick="${!nextDisabled ? 'goToPage(' + (info.page + 1) + ')' : 'return false;'}" ${nextDisabled ? 'disabled' : ''}
                    class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-lg transition-colors duration-200 ${nextDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50 hover:text-gray-700'}">
                    بعدی
                </button>`;
            }

            $('#tablePagination').html(paginationHtml);
        }

        function goToPage(pageNumber) {
            usersTable.page(pageNumber).draw('page');
        }

        function refreshTable() {
            usersTable.ajax.reload(null, false);
            showToast('جدول با موفقیت بروزرسانی شد', 'success');
        }

        function exportData(format = 'csv') {
            const searchValue = $('#searchInput').val();
            const statusValue = $('#statusFilter').val();
            const roleValue = $('#roleFilter').val();

            const params = new URLSearchParams({
                format: format,
                search: searchValue || '',
                status: statusValue || '',
                role: roleValue || ''
            });

            // Create download link
            const downloadUrl = `{{ route("panel.users.export") }}?${params.toString()}`;

            // Trigger download
            window.location.href = downloadUrl;

            const formatText = format === 'html' ? 'Excel' : 'CSV';
            showToast(`درحال تهیه فایل ${formatText}...`, 'info');

            // Close dropdown
            $('#exportDropdown').addClass('hidden');
        }

        function toggleExportDropdown() {
            $('#exportDropdown').toggleClass('hidden');
        }

        // Close dropdown when clicking outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#exportDropdown').length && !$(e.target).closest('button[onclick*="toggleExportDropdown"]').length) {
                $('#exportDropdown').addClass('hidden');
            }
        });

        function editUser(userId) {
            currentUserId = userId;

            // Show modal with loading state
            $('#editModal').removeClass('hidden').addClass('flex');
            $('#modalBody').html(`
                <div class="flex items-center justify-center py-12">
                    <div class="text-center">
                        <div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                        <p class="text-gray-500">در حال بارگذاری فرم ویرایش...</p>
                    </div>
                </div>
            `);

            // Load edit form
            $.get(`{{ route('panel.users.index') }}/${userId}/edit`)
                .done(function (response) {
                    if (response.success) {
                        $('#modalBody').html(response.html);
                        bindModalFormEvents();
                    }
                })
                .fail(function () {
                    showToast('خطا در بارگذاری اطلاعات', 'error');
                    closeEditModal();
                });
        }

        function bindModalFormEvents() {
            // Bind form submission
            $('#editUserForm').off('submit').on('submit', function (e) {
                e.preventDefault();
                updateUser();
            });
        }

        function updateUser() {
            const form = $('#editUserForm');
            const submitBtn = form.find('button[type="submit"]');
            const loading = $('#submitLoading');

            submitBtn.prop('disabled', true);
            loading.removeClass('opacity-0');

            const formData = new FormData(form[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('_method', 'PUT');

            $.ajax({
                url: `{{ route('panel.users.index') }}/${currentUserId}`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        closeEditModal();
                        usersTable.ajax.reload(null, false);
                        showToast(response.message, 'success');
                    }
                },
                error: function (xhr) {
                    handleFormErrors(xhr);
                },
                complete: function () {
                    submitBtn.prop('disabled', false);
                    loading.addClass('opacity-0');
                }
            });
        }

        function toggleUserStatus(userId, currentStatus) {
            const newStatus = currentStatus == 1 ? 0 : 1;
            const statusText = newStatus ? 'فعال' : 'غیرفعال';

            if (!confirm(`آیا مطمئن هستید که می‌خواهید این کاربر را ${statusText} کنید؟`)) {
                return;
            }

            $.ajax({
                url: `{{ route('panel.users.index') }}/${userId}/toggle-status`,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        usersTable.ajax.reload(null, false);
                        showToast(response.message, 'success');
                    }
                },
                error: function () {
                    showToast('خطا در تغییر وضعیت کاربر', 'error');
                }
            });
        }

        function closeEditModal() {
            $('#editModal').removeClass('flex').addClass('hidden');
            currentUserId = null;
            $('#modalBody').html('');
        }

        function handleFormErrors(xhr) {
            const errors = xhr.responseJSON?.errors;
            if (errors) {
                Object.values(errors).forEach(errorArray => {
                    errorArray.forEach(error => {
                        showToast(error, 'error');
                    });
                });
            } else {
                showToast('خطا در ثبت اطلاعات', 'error');
            }
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

            const toast = $(`
                <div id="${toastId}" class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-lg transform translate-x-full transition-all duration-300 border-l-4 ${type === 'success' ? 'border-green-500' : type === 'error' ? 'border-red-500' : 'border-blue-500'}" role="alert">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${colorMap[type]}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            ${iconMap[type]}
                        </svg>
                    </div>
                    <div class="mr-3 text-sm font-normal">${message}</div>
                    <button type="button" onclick="removeToast('${toastId}')" class="mr-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5">
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
    </script>
@endpush
