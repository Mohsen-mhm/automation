@extends('layouts.app')

@section('title', 'مدیریت نقش‌ها')

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
                            class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center ml-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 22 20">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M20 10a28.076 28.076 0 0 1-1.091 9M6.231 2.37a8.994 8.994 0 0 1 12.88 3.73M1.958 13S2 12.577 2 10a8.949 8.949 0 0 1 1.735-5.307m12.84 3.088c.281.706.426 1.46.425 2.22a30 30 0 0 1-.464 6.231M5 10a6 6 0 0 1 9.352-4.974M3 19a5.964 5.964 0 0 1 1.01-3.328 5.15 5.15 0 0 0 .786-1.926m8.66 2.486a13.96 13.96 0 0 1-.962 2.683M6.5 17.336C8 15.092 8 12.846 8 10a3 3 0 1 1 6 0c0 .75 0 1.521-.031 2.311M11 10.001c0 3 0 6-2 9"/>
                            </svg>
                        </div>
                        مدیریت نقش‌ها
                    </h1>
                    <p class="text-gray-600 mt-1">مدیریت نقش‌ها و تخصیص دسترسی‌ها</p>
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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-indigo-100 text-sm">کل نقش‌ها</p>
                        <p class="text-2xl font-bold" id="totalRoles">-</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 22 20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 10a28.076 28.076 0 0 1-1.091 9M6.231 2.37a8.994 8.994 0 0 1 12.88 3.73M1.958 13S2 12.577 2 10a8.949 8.949 0 0 1 1.735-5.307m12.84 3.088c.281.706.426 1.46.425 2.22a30 30 0 0 1-.464 6.231M5 10a6 6 0 0 1 9.352-4.974M3 19a5.964 5.964 0 0 1 1.01-3.328 5.15 5.15 0 0 0 .786-1.926m8.66 2.486a13.96 13.96 0 0 1-.962 2.683M6.5 17.336C8 15.092 8 12.846 8 10a3 3 0 1 1 6 0c0 .75 0 1.521-.031 2.311M11 10.001c0 3 0 6-2 9"/>
                        </svg>
                    </div>
                </div>
            </div>

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
        </div>

        <!-- Enhanced Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="p-6 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <h2 class="text-lg font-semibold text-gray-900">لیست نقش‌ها</h2>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            <span id="roleCount">-</span> نقش
                        </span>
                    </div>

                    <!-- Search Only -->
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="search" id="searchInput"
                               class="block w-64 pr-10 pl-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                               placeholder="جستجو در نقش‌ها...">
                    </div>
                </div>
            </div>

            <!-- Modern Table -->
            <div class="overflow-x-auto">
                <table id="rolesTable" class="w-full">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            ردیف
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            عنوان
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

    @can(\App\Models\Permission::PERMISSION_ASSIGN)
        <!-- Enhanced Assignment Modal -->
        <div id="assignModal"
             class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div
                class="relative bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                <!-- Modal Header -->
                <div
                    class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-indigo-500 to-purple-600">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">تخصیص دسترسی‌ها</h3>
                            <p class="text-white/80 text-sm" id="roleTitle">انتخاب دسترسی‌ها برای نقش</p>
                        </div>
                    </div>
                    <button onclick="closeAssignModal()"
                            class="text-white/80 hover:text-white transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-180px)]">
                    <form id="assignPermissionsForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="roleId" name="role_id">

                        <!-- Search Permissions -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">جستجو در دسترسی‌ها</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="search" id="permissionSearch"
                                       class="block w-full pr-10 pl-4 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                       placeholder="نام دسترسی را وارد کنید...">
                            </div>
                        </div>

                        <!-- Select All / Deselect All -->
                        <div class="mb-6 p-4 bg-indigo-50 rounded-xl border border-indigo-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-indigo-900">انتخاب سریع</h4>
                                        <p class="text-sm text-indigo-700">انتخاب یا لغو انتخاب همه دسترسی‌ها</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2 rtl:space-x-reverse">
                                    <button type="button" onclick="selectAllPermissions()"
                                            class="px-3 py-1.5 text-xs font-medium text-indigo-700 bg-white hover:bg-indigo-50 border border-indigo-200 rounded-lg transition-colors duration-200">
                                        انتخاب همه
                                    </button>
                                    <button type="button" onclick="deselectAllPermissions()"
                                            class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 border border-gray-200 rounded-lg transition-colors duration-200">
                                        لغو همه
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Permissions List -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-medium text-gray-900">لیست دسترسی‌ها</h4>
                                <span id="selectedCount" class="text-sm text-gray-500">0 انتخاب شده</span>
                            </div>
                            <div id="permissionsList"
                                 class="space-y-2 max-h-96 overflow-y-auto border border-gray-200 rounded-xl p-4">
                                <!-- Permissions will be populated here -->
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div
                            class="flex justify-end space-x-3 rtl:space-x-reverse pt-4 border-t border-gray-200">
                            <button type="button" onclick="closeAssignModal()"
                                    class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 font-medium">
                                انصراف
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"/>
                                </svg>
                                ذخیره تغییرات
                                <div class="mr-2 opacity-0 transition-opacity duration-200" id="assignLoading">
                                    <div
                                        class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                </div>
                            </button>
                        </div>
                    </form>
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

        #rolesTable tbody tr {
            transition: all 0.2s ease;
        }

        #rolesTable tbody tr:hover {
            background-color: rgba(99, 102, 241, 0.05);
            transform: translateX(-2px);
        }

        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar,
        #permissionsList::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track,
        #permissionsList::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb,
        #permissionsList::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover,
        #permissionsList::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Permission checkbox styles */
        .permission-item {
            transition: all 0.2s ease;
        }

        .permission-item:hover {
            background-color: rgba(99, 102, 241, 0.05);
            border-color: rgba(99, 102, 241, 0.2);
        }

        .permission-item input[type="checkbox"]:checked + label {
            color: #4338ca;
            font-weight: 500;
        }

        .permission-item.selected {
            background-color: rgba(99, 102, 241, 0.1);
            border-color: #4338ca;
        }

        /* Custom checkbox */
        .custom-checkbox {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            background: white;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            flex-shrink: 0;
        }

        .custom-checkbox:checked {
            background: #4338ca;
            border-color: #4338ca;
        }

        .custom-checkbox:checked::after {
            content: '✓';
            color: white;
            font-size: 12px;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .custom-checkbox:hover {
            border-color: #6366f1;
        }

        /* Loading state */
        .permissions-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            color: #6b7280;
        }

        /* Empty state */
        .permissions-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            color: #6b7280;
            text-align: center;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        let rolesTable;
        let currentRolePermissions = [];
        let allPermissions = [];
        let filteredPermissions = [];

        $(document).ready(function () {
            initializeDataTable();
            bindEventHandlers();
            updateStats();
        });

        function initializeDataTable() {
            rolesTable = $('#rolesTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ordering: false,
                ajax: {
                    url: '{{ route("panel.roles.data") }}',
                    type: 'GET',
                    data: function (d) {
                        d.search.value = $('#searchInput').val();
                    }
                },
                columns: [
                    {
                        data: 0,
                        name: 'id',
                        render: function (data, type, row, meta) {
                            return `<span class="inline-flex items-center justify-center w-8 h-8 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-full">${data}</span>`;
                        }
                    },
                    {
                        data: 1,
                        name: 'title',
                        render: function (data, type, row) {
                            return `<div class="font-medium text-gray-900">${data}</div>`;
                        }
                    },
                    {
                        data: 2,
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
                    emptyTable: "هیچ داده‌ای در جدول وجود ندارد",
                    zeroRecords: "هیچ رکوردی یافت نشد"
                },
                dom: 'rt',
                drawCallback: function (settings) {
                    bindAssignButtons();
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
                rolesTable.draw();
            }, 300));

            // Page length change
            $('#pageLength').on('change', function () {
                rolesTable.page.len($(this).val()).draw();
            });

            // Assignment form submission
            $('#assignPermissionsForm').on('submit', function (e) {
                e.preventDefault();
                updateRolePermissions();
            });

            // Permission search
            $('#permissionSearch').on('keyup', debounce(function () {
                filterPermissions();
            }, 300));

            // Modal close handlers
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') closeAssignModal();
            });

            $('#assignModal').on('click', function (e) {
                if (e.target === this) closeAssignModal();
            });
        }

        function bindAssignButtons() {
            $('.btn-assign').off('click').on('click', function () {
                const roleId = $(this).data('role-id');
                assignRole(roleId);
            });
        }

        function updateTableInfo(settings) {
            const info = rolesTable.page.info();
            $('#tableInfo').html(`نمایش ${info.start + 1} تا ${info.end} از ${info.recordsTotal} ردیف`);
            $('#roleCount').text(info.recordsTotal);
        }

        function updatePagination(settings) {
            const info = rolesTable.page.info();
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
                        class="px-3 py-2 text-sm font-medium transition-colors duration-200 ${i === info.page ? 'text-indigo-600 bg-indigo-50 border-indigo-300' : 'text-gray-500 bg-white border-gray-300 hover:text-gray-700 hover:bg-gray-50'} border">
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
                rolesTable.page('previous').draw('page');
            } else if (page === 'next') {
                rolesTable.page('next').draw('page');
            } else {
                rolesTable.page(page).draw('page');
            }
        }

        function updateStats() {
            $.get('{{ route("panel.roles.data") }}', {length: -1})
                .done(function (response) {
                    $('#totalRoles').text(response.recordsTotal || 0);
                });

            // Get total permissions count
            $.get('{{ route("panel.permissions.data") }}', {length: -1})
                .done(function (response) {
                    $('#totalPermissions').text(response.recordsTotal || 0);
                })
                .fail(function () {
                    $('#totalPermissions').text('N/A');
                });
        }

        function refreshTable() {
            rolesTable.ajax.reload(null, false);
            updateStats();
            showToast('جدول با موفقیت بروزرسانی شد', 'success');
        }

        function exportData() {
            window.location.href = '{{ route("panel.roles.export") }}?format=excel';
            showToast('درحال تهیه فایل Excel...', 'info');
        }

        function assignRole(roleId) {
            $.get(`{{ route('panel.roles.index') }}/${roleId}/edit`)
                .done(function (response) {
                    if (response.success) {
                        populateAssignForm(response);
                        $('#assignModal').removeClass('hidden').addClass('flex');
                    }
                })
                .fail(function () {
                    showToast('خطا در بارگذاری اطلاعات', 'error');
                });
        }

        function populateAssignForm(response) {
            const role = response.role;
            const permissions = response.permissions;
            currentRolePermissions = response.rolePermissions;
            allPermissions = permissions;
            filteredPermissions = permissions;

            $('#roleId').val(role.id);
            $('#roleTitle').text(`نقش: ${role.title}`);

            renderPermissions(permissions);
            updateSelectedCount();
        }

        function renderPermissions(permissions) {
            const container = $('#permissionsList');

            if (permissions.length === 0) {
                container.html(`
                    <div class="permissions-empty">
                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-gray-500">هیچ دسترسی یافت نشد</p>
                        <p class="text-sm text-gray-400 mt-1">جستجوی خود را تغییر دهید</p>
                    </div>
                `);
                return;
            }

            container.empty();

            permissions.forEach(permission => {
                const isChecked = currentRolePermissions.includes(permission.id);
                const permissionHtml = `
                    <div class="permission-item ${isChecked ? 'selected' : ''} flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:border-indigo-300 transition-all duration-200">
                        <input type="checkbox"
                               id="permission_${permission.id}"
                               name="permissions[]"
                               value="${permission.id}"
                               ${isChecked ? 'checked' : ''}
                               onchange="togglePermissionSelection(${permission.id})"
                               class="custom-checkbox mr-3">
                        <label for="permission_${permission.id}"
                               class="flex-1 text-gray-900 font-medium cursor-pointer select-none">
                            ${permission.title}
                        </label>
                        <div class="text-xs text-gray-400">
                            ID: ${permission.id}
                        </div>
                    </div>
                `;
                container.append(permissionHtml);
            });
        }

        function filterPermissions() {
            const searchTerm = $('#permissionSearch').val().toLowerCase();
            filteredPermissions = allPermissions.filter(permission =>
                permission.title.toLowerCase().includes(searchTerm)
            );
            renderPermissions(filteredPermissions);
            updateSelectedCount();
        }

        function selectAllPermissions() {
            filteredPermissions.forEach(permission => {
                if (!currentRolePermissions.includes(permission.id)) {
                    currentRolePermissions.push(permission.id);
                }
            });
            renderPermissions(filteredPermissions);
            updateSelectedCount();
            showToast(`${filteredPermissions.length} دسترسی انتخاب شد`, 'success');
        }

        function deselectAllPermissions() {
            const filteredIds = filteredPermissions.map(p => p.id);
            currentRolePermissions = currentRolePermissions.filter(id => !filteredIds.includes(id));
            renderPermissions(filteredPermissions);
            updateSelectedCount();
            showToast('انتخاب دسترسی‌ها لغو شد', 'info');
        }

        function togglePermissionSelection(permissionId) {
            const index = currentRolePermissions.indexOf(permissionId);
            if (index > -1) {
                currentRolePermissions.splice(index, 1);
            } else {
                currentRolePermissions.push(permissionId);
            }

            // Update visual state
            const permissionItem = $(`#permission_${permissionId}`).closest('.permission-item');
            const isChecked = $(`#permission_${permissionId}`).is(':checked');

            if (isChecked) {
                permissionItem.addClass('selected');
            } else {
                permissionItem.removeClass('selected');
            }

            updateSelectedCount();
        }

        function updateSelectedCount() {
            const selectedCount = currentRolePermissions.length;
            $('#selectedCount').text(`${selectedCount} انتخاب شده`);
        }

        function updateRolePermissions() {
            const submitBtn = $('#assignPermissionsForm button[type="submit"]');
            const loading = $('#assignLoading');

            submitBtn.prop('disabled', true);
            loading.removeClass('opacity-0');

            const roleId = $('#roleId').val();
            const formData = new FormData();

            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('_method', 'PUT');

            // Add selected permissions
            currentRolePermissions.forEach((permission, index) => {
                formData.append(`permissions[${index}]`, permission);
            });

            $.ajax({
                url: `{{ route('panel.roles.index') }}/${roleId}`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        closeAssignModal();
                        rolesTable.ajax.reload(null, false);
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

        function closeAssignModal() {
            $('#assignModal').removeClass('flex').addClass('hidden');
            currentRolePermissions = [];
            allPermissions = [];
            filteredPermissions = [];
            $('#assignPermissionsForm')[0].reset();
            $('#permissionSearch').val('');
            $('#permissionsList').empty();
            $('#selectedCount').text('0 انتخاب شده');
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
    </script>
@endpush
