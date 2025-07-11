@extends('layouts.app')

@section('title', 'مدیریت استان‌ها')

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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                        </div>
                        مدیریت استان‌ها
                    </h1>
                    <p class="text-gray-600 mt-1">مدیریت استان‌های کشور</p>
                </div>
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    @can(\App\Models\Province::PROVINCE_CREATE)
                        <!-- Add New Province Button -->
                        <button onclick="showCreateModal()"
                                class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v16m8-8H4"/>
                            </svg>
                            افزودن استان جدید
                        </button>
                    @endcan
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
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">کل استان‌ها</p>
                        <p class="text-2xl font-bold" id="totalProvinces">-</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm">استان‌های فعال</p>
                        <p class="text-2xl font-bold" id="activeProvinces">-</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm">کل شهرها</p>
                        <p class="text-2xl font-bold" id="totalCities">-</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
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
                        <h2 class="text-lg font-semibold text-gray-900">لیست استان‌ها</h2>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <span id="provinceCount">-</span> استان
                        </span>
                    </div>

                    <!-- Filters -->
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <!-- Status Filter -->
                        <select id="statusFilter"
                                class="border border-gray-300 rounded-lg px-3 py-2 bg-white text-gray-900 text-sm">
                            <option value="">همه وضعیت‌ها</option>
                            <option value="1">فعال</option>
                            <option value="0">غیرفعال</option>
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
                                   class="block w-64 pr-10 pl-4 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                   placeholder="جستجو در استان‌ها...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modern Table -->
            <div class="overflow-x-auto">
                <table id="provincesTable" class="w-full">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            ردیف
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            نام استان
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            تعداد شهر
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            وضعیت
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            ترتیب
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            تاریخ ثبت
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

    <!-- Create/Edit Modal -->
    <div id="modal"
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
                                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white" id="modalTitle">مدیریت استان</h3>
                </div>
                <button onclick="closeModal()"
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
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
         class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">تایید حذف</h3>
                        <p class="text-sm text-gray-500">حذف استان</p>
                    </div>
                </div>
                <button onclick="closeDeleteModal()"
                        class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="text-center mb-6">
                    <p class="text-gray-700 mb-2">آیا از حذف استان <span id="deleteProvinceName"
                                                                         class="font-semibold"></span> مطمئن هستید؟</p>
                    <p class="text-sm text-red-600" id="deleteWarning"></p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end space-x-3 rtl:space-x-reverse p-6 border-t border-gray-200">
                <button onclick="closeDeleteModal()"
                        class="px-6 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 font-medium">
                    انصراف
                </button>
                <button id="confirmDeleteBtn"
                        class="px-6 py-2.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-xl transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span>حذف استان</span>
                    </div>
                </button>
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

        #provincesTable tbody tr {
            transition: all 0.2s ease;
        }

        #provincesTable tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.05);
            transform: translateX(-2px);
        }

        /* Modal animations */
        #modal, #deleteModal {
            backdrop-filter: blur(8px);
        }

        #modal > div, #deleteModal > div {
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
        let provincesTable;
        let currentProvinceId = null;

        $(document).ready(function () {
            initializeDataTable();
            bindEventHandlers();
            updateStats();
        });

        function initializeDataTable() {
            provincesTable = $('#provincesTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ordering: false,
                searching: false,
                lengthChange: false,
                ajax: {
                    url: '{{ route("panel.provinces.data") }}',
                    type: 'GET',
                    data: function (d) {
                        d.search = {
                            value: $('#searchInput').val() || '',
                            regex: false
                        };
                        d.status = $('#statusFilter').val();
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
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            return `<span class="inline-flex items-center justify-center w-8 h-8 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">${data}</span>`;
                        }
                    },
                    {
                        data: 1,
                        orderable: false,
                        render: function (data) {
                            return `<div class="font-medium text-gray-900">${data}</div>`;
                        }
                    },
                    {
                        data: 2,
                        orderable: false,
                        className: 'text-center',
                        render: function (data) {
                            return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">${data}</span>`;
                        }
                    },
                    {
                        data: 3,
                        orderable: false,
                        className: 'text-center',
                        render: function (data) {
                            return data;
                        }
                    },
                    {
                        data: 4,
                        orderable: false,
                        className: 'text-center',
                        render: function (data) {
                            return `<span class="text-gray-600">${data}</span>`;
                        }
                    },
                    {
                        data: 5,
                        orderable: false,
                        className: 'text-center',
                        render: function (data) {
                            return `<span class="text-gray-600 text-sm">${data}</span>`;
                        }
                    },
                    {
                        data: 6,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function (data) {
                            return data;
                        }
                    }
                ],
                pageLength: 25,
                language: {
                    processing: "در حال پردازش...",
                    emptyTable: "هیچ استانی ثبت نشده است",
                    zeroRecords: "هیچ رکوردی یافت نشد"
                },
                dom: 'rt',
                drawCallback: function (settings) {
                    bindActionButtons();
                    updateTableInfo(settings);
                    updatePagination(settings);
                },
                initComplete: function () {
                    updateStats();
                }
            });
        }

        function bindEventHandlers() {
            // Search with debouncing
            $('#searchInput').on('keyup', debounce(function () {
                provincesTable.draw();
            }, 300));

            // Status filter
            $('#statusFilter').on('change', function () {
                provincesTable.draw();
            });

            // Page length change
            $('#pageLength').on('change', function () {
                const newLength = parseInt($(this).val());
                provincesTable.page.len(newLength).draw();
            });

            // Modal close handlers
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeModal();
                    closeDeleteModal();
                }
            });

            $('#modal').on('click', function (e) {
                if (e.target === this) closeModal();
            });

            $('#deleteModal').on('click', function (e) {
                if (e.target === this) closeDeleteModal();
            });
        }

        function bindActionButtons() {
            $('.btn-edit').off('click').on('click', function () {
                const provinceId = $(this).data('province-id');
                editProvince(provinceId);
            });

            $('.btn-toggle').off('click').on('click', function () {
                const provinceId = $(this).data('province-id');
                toggleProvinceStatus(provinceId);
            });

            $('.btn-delete').off('click').on('click', function () {
                const provinceId = $(this).data('province-id');
                const provinceName = $(this).data('province-name');
                const citiesCount = $(this).data('cities-count');
                showDeleteModal(provinceId, provinceName, citiesCount);
            });
        }

        function showCreateModal() {
            $('#modalTitle').text('افزودن استان جدید');
            $('#modal').removeClass('hidden').addClass('flex');
            $('#modalBody').html(`
                <div class="flex items-center justify-center py-12">
                    <div class="text-center">
                        <div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                        <p class="text-gray-500">در حال بارگذاری فرم...</p>
                    </div>
                </div>
            `);

            $.get('{{ route("panel.provinces.create") }}')
                .done(function (response) {
                    if (response.success) {
                        $('#modalBody').html(response.html);
                        bindModalFormEvents();
                    }
                })
                .fail(function () {
                    showToast('خطا در بارگذاری فرم', 'error');
                    closeModal();
                });
        }

        function editProvince(provinceId) {
            $('#modalTitle').text('ویرایش استان');
            $('#modal').removeClass('hidden').addClass('flex');
            $('#modalBody').html(`
                <div class="flex items-center justify-center py-12">
                    <div class="text-center">
                        <div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                        <p class="text-gray-500">در حال بارگذاری اطلاعات...</p>
                    </div>
                </div>
            `);

            $.get(`{{ route('panel.provinces.index') }}/${provinceId}/edit`)
                .done(function (response) {
                    if (response.success) {
                        $('#modalBody').html(response.html);
                        currentProvinceId = response.province_id;
                        bindModalFormEvents();
                    }
                })
                .fail(function () {
                    showToast('خطا در بارگذاری اطلاعات', 'error');
                    closeModal();
                });
        }

        function bindModalFormEvents() {
            $('#provinceForm').off('submit').on('submit', function (e) {
                e.preventDefault();
                submitForm();
            });
        }

        function submitForm() {
            const form = $('#provinceForm');
            const submitBtn = form.find('button[type="submit"]');
            const loading = $('#submitLoading');

            submitBtn.prop('disabled', true);
            loading.removeClass('opacity-0');

            const formData = new FormData(form[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            let url = '{{ route("panel.provinces.store") }}';
            let method = 'POST';

            if (currentProvinceId) {
                url = `{{ route('panel.provinces.index') }}/${currentProvinceId}`;
                formData.append('_method', 'PUT');
            }

            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        closeModal();
                        provincesTable.ajax.reload(null, false);
                        updateStats();
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

        function toggleProvinceStatus(provinceId) {
            $.post(`{{ route('panel.provinces.index') }}/${provinceId}/toggle-status`, {
                _token: $('meta[name="csrf-token"]').attr('content')
            })
                .done(function (response) {
                    if (response.success) {
                        provincesTable.ajax.reload(null, false);
                        updateStats();
                        showToast(response.message, 'success');
                    }
                })
                .fail(function (xhr) {
                    const message = xhr.responseJSON?.message || 'خطا در تغییر وضعیت';
                    showToast(message, 'error');
                });
        }

        function showDeleteModal(provinceId, provinceName, citiesCount) {
            currentProvinceId = provinceId;
            $('#deleteProvinceName').text(provinceName);

            if (citiesCount > 0) {
                $('#deleteWarning').text(`این استان دارای ${citiesCount} شهر می‌باشد و قابل حذف نیست.`);
                $('#confirmDeleteBtn').prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
            } else {
                $('#deleteWarning').text('این عمل قابل بازگشت نیست.');
                $('#confirmDeleteBtn').prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
            }

            $('#deleteModal').removeClass('hidden').addClass('flex');

            $('#confirmDeleteBtn').off('click').on('click', function () {
                if (citiesCount === 0) {
                    deleteProvince(provinceId);
                }
            });
        }

        function deleteProvince(provinceId) {
            const deleteBtn = $('#confirmDeleteBtn');
            const originalText = deleteBtn.html();

            deleteBtn.prop('disabled', true).html(`
                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                    <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                    <span>در حال حذف...</span>
                </div>
            `);

            $.ajax({
                url: `{{ route('panel.provinces.index') }}/${provinceId}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        closeDeleteModal();
                        provincesTable.ajax.reload(null, false);
                        updateStats();
                        showToast(response.message, 'success');
                    }
                },
                error: function (xhr) {
                    const message = xhr.responseJSON?.message || 'خطا در حذف استان';
                    showToast(message, 'error');
                },
                complete: function () {
                    deleteBtn.prop('disabled', false).html(originalText);
                }
            });
        }

        function closeModal() {
            $('#modal').removeClass('flex').addClass('hidden');
            currentProvinceId = null;
            $('#modalBody').html('');
        }

        function closeDeleteModal() {
            $('#deleteModal').removeClass('flex').addClass('hidden');
            currentProvinceId = null;
        }

        function updateTableInfo(settings) {
            const info = provincesTable.page.info();

            if (info.recordsTotal > 0) {
                $('#tableInfo').html(`نمایش ${info.start + 1} تا ${info.end} از ${info.recordsTotal} ردیف`);
                $('#provinceCount').text(info.recordsTotal);
            } else {
                $('#tableInfo').html('هیچ رکوردی یافت نشد');
                $('#provinceCount').text('0');
            }
        }

        function updatePagination(settings) {
            const info = provincesTable.page.info();
            let paginationHtml = '';

            if (info.pages > 1) {
                const prevDisabled = info.page === 0;
                paginationHtml += `<button type="button" onclick="${!prevDisabled ? 'goToPage(' + (info.page - 1) + ')' : 'return false;'}" ${prevDisabled ? 'disabled' : ''}
                    class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-lg transition-colors duration-200 ${prevDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50 hover:text-gray-700'}">
                    قبلی
                </button>`;

                const startPage = Math.max(0, info.page - 2);
                const endPage = Math.min(info.pages - 1, info.page + 2);

                for (let i = startPage; i <= endPage; i++) {
                    const isActive = i === info.page;
                    paginationHtml += `<button type="button" onclick="goToPage(${i})"
                        class="px-3 py-2 text-sm font-medium transition-colors duration-200 border ${isActive ? 'text-blue-600 bg-blue-50 border-blue-300' : 'text-gray-500 bg-white border-gray-300 hover:text-gray-700 hover:bg-gray-50'}">
                        ${i + 1}
                    </button>`;
                }

                const nextDisabled = info.page === info.pages - 1;
                paginationHtml += `<button type="button" onclick="${!nextDisabled ? 'goToPage(' + (info.page + 1) + ')' : 'return false;'}" ${nextDisabled ? 'disabled' : ''}
                    class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-lg transition-colors duration-200 ${nextDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50 hover:text-gray-700'}">
                    بعدی
                </button>`;
            }

            $('#tablePagination').html(paginationHtml);
        }

        function goToPage(pageNumber) {
            provincesTable.page(pageNumber).draw('page');
        }

        function updateStats() {
            $.get('{{ route("panel.provinces.data") }}', {length: -1})
                .done(function (response) {
                    $('#totalProvinces').text(response.recordsTotal || 0);

                    // Count active provinces
                    let activeCount = 0;
                    let totalCities = 0;

                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function (row) {
                            // Check if status badge contains 'فعال'
                            if (row[3] && row[3].includes('فعال') && !row[3].includes('غیرفعال')) {
                                activeCount++;
                            }
                            // Add cities count (column index 2)
                            totalCities += parseInt(row[2]) || 0;
                        });
                    }

                    $('#activeProvinces').text(activeCount);
                    $('#totalCities').text(totalCities);
                });
        }

        function refreshTable() {
            provincesTable.ajax.reload(null, false);
            updateStats();
            showToast('جدول با موفقیت بروزرسانی شد', 'success');
        }

        function exportData() {
            const search = $('#searchInput').val();
            const status = $('#statusFilter').val();
            let url = '{{ route("panel.provinces.export") }}?format=excel';

            if (search) url += '&search=' + encodeURIComponent(search);
            if (status !== '') url += '&status=' + status;

            window.location.href = url;
            showToast('درحال تهیه فایل Excel...', 'info');
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

        if (!$('meta[name="csrf-token"]').attr('content')) {
            $('head').append('<meta name="csrf-token" content="{{ csrf_token() }}">');
        }
    </script>
@endpush
