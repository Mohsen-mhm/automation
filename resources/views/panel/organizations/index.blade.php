@extends('layouts.app')

@section('title', 'مدیریت کاربران سازمانی')

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
                            class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl flex items-center justify-center ml-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                        مدیریت کاربران سازمانی
                    </h1>
                    <p class="text-gray-600 mt-1">مدیریت اطلاعات کاربران سازمانی ثبت شده در سیستم</p>
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
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm">کل کاربران</p>
                        <p class="text-2xl font-bold" id="totalOrganizations">-</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm">کاربران فعال</p>
                        <p class="text-2xl font-bold" id="activeOrganizations">-</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-amber-500 to-amber-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm">در انتظار تایید</p>
                        <p class="text-2xl font-bold" id="pendingOrganizations">-</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
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
                        <h2 class="text-lg font-semibold text-gray-900">لیست کاربران سازمانی</h2>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                    <span id="organizationCount">-</span> کاربر
                </span>
                    </div>

                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        @can(\App\Models\OrganizationUser::ORGAN_CREATE)
                            <button onclick="openCreateModal()"
                                    class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 4v16m8-8H4"/>
                                </svg>
                                افزودن کاربر سازمانی
                            </button>
                        @endcan

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
                                   class="block w-64 pr-10 pl-4 py-2.5 text-sm text-gray-900 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                   placeholder="جستجو در کاربران...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Table -->
    <div class="overflow-x-auto">
        <table id="organizationsTable" class="w-full">
            <thead>
            <tr class="bg-gray-50 border-b border-gray-200">
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    ردیف
                </th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    نام و نام خانوادگی
                </th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    کد ملی
                </th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    سازمان
                </th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    سمت
                </th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    تلفن همراه
                </th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    وضعیت
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

    <!-- Dynamic Modals -->
    @can(\App\Models\OrganizationUser::ORGAN_CREATE)
        <!-- Create Modal -->
        <div id="createModal"
             class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div
                class="relative bg-white rounded-2xl shadow-2xl max-w-6xl w-full max-h-[95vh] overflow-hidden">
                <!-- Modal Header -->
                <div
                    class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-500 to-teal-600">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">افزودن کاربر سازمانی جدید</h3>
                    </div>
                    <button onclick="closeCreateModal()"
                            class="text-white/80 hover:text-white transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]" id="createModalBody">
                    <!-- Dynamic content will be loaded here -->
                    <div class="flex items-center justify-center py-12">
                        <div class="text-center">
                            <div
                                class="w-16 h-16 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                            <p class="text-gray-500">در حال بارگذاری...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can(\App\Models\OrganizationUser::ORGAN_EDIT)
        <!-- Edit Modal -->
        <div id="editModal"
             class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div
                class="relative bg-white rounded-2xl shadow-2xl max-w-6xl w-full max-h-[95vh] overflow-hidden">
                <!-- Modal Header -->
                <div
                    class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-cyan-600">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">ویرایش کاربر سازمانی</h3>
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
                <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]" id="editModalBody">
                    <!-- Dynamic content will be loaded here -->
                </div>
            </div>
        </div>
    @endcan

    <!-- Show Modal -->
    <div id="showModal"
         class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
        <div
            class="relative bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[95vh] overflow-hidden">
            <!-- Modal Header -->
            <div
                class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-indigo-500 to-purple-600">
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white">اطلاعات کاربر سازمانی</h3>
                </div>
                <button onclick="closeShowModal()"
                        class="text-white/80 hover:text-white transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]" id="showModalBody">
                <!-- Dynamic content will be loaded here -->
            </div>
        </div>
    </div>

    @can(\App\Models\OrganizationUser::ORGAN_DELETE)
        <!-- Delete Confirmation Modal -->
        <div id="deleteModal"
             class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
                <!-- Modal Header -->
                <div
                    class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-red-500 to-red-600">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">حذف کاربر سازمانی</h3>
                    </div>
                    <button onclick="closeDeleteModal()"
                            class="text-white/80 hover:text-white transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">تایید حذف</h3>
                    <p class="text-gray-600 mb-6">آیا مطمئن هستید که می‌خواهید این کاربر سازمانی را حذف کنید؟ این عمل
                        قابل بازگشت
                        نیست.</p>

                    <div class="flex items-center justify-center space-x-3 rtl:space-x-reverse">
                        <button onclick="closeDeleteModal()"
                                class="px-6 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 font-medium">
                            انصراف
                        </button>
                        <button onclick="confirmDelete()"
                                class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-colors duration-200 font-medium">
                            حذف
                        </button>
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

        #organizationsTable tbody tr {
            transition: all 0.2s ease;
        }

        #organizationsTable tbody tr:hover {
            background-color: rgba(139, 69, 19, 0.05);
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

        /* Modal animations */
        .modal-enter {
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
        let organizationsTable;
        let currentOrganizationId = null;

        $(document).ready(function () {
            initializeDataTable();
            bindEventHandlers();
            updateStats();
        });

        function initializeDataTable() {
            organizationsTable = $('#organizationsTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ordering: false,
                searching: false,
                lengthChange: false,
                ajax: {
                    url: '{{ route("panel.organizations.data") }}',
                    type: 'GET',
                    data: function (d) {
                        d.search = {
                            value: $('#searchInput').val() || '',
                            regex: false
                        };
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
                            return `<span class="inline-flex items-center justify-center w-8 h-8 text-xs font-medium text-purple-700 bg-purple-100 rounded-full">${data}</span>`;
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
                    {data: 2, name: 'national_id', orderable: false},
                    {data: 3, name: 'organization_name', orderable: false},
                    {data: 4, name: 'organization_level', orderable: false},
                    {data: 5, name: 'phone_number', orderable: false},
                    {
                        data: 6,
                        name: 'status',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return data;
                        }
                    },
                    {data: 7, name: 'created_at', orderable: false},
                    {
                        data: 8,
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
                    bindActionButtons();
                    updateTableInfo(settings);
                    updatePagination(settings);
                },
                initComplete: function () {
                    updateStats();
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
                organizationsTable.draw();
            }, 300));

            // Page length change
            $('#pageLength').on('change', function () {
                const newLength = parseInt($(this).val());
                organizationsTable.page.len(newLength).draw();
            });

            // Modal close handlers
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeCreateModal();
                    closeEditModal();
                    closeShowModal();
                    closeDeleteModal();
                }
            });

            $('.modal').on('click', function (e) {
                if (e.target === this) {
                    closeCreateModal();
                    closeEditModal();
                    closeShowModal();
                    closeDeleteModal();
                }
            });
        }

        function bindActionButtons() {
            $('.btn-show').off('click').on('click', function () {
                const organizationId = $(this).data('organization-id');
                showOrganization(organizationId);
            });

            $('.btn-edit').off('click').on('click', function () {
                const organizationId = $(this).data('organization-id');
                editOrganization(organizationId);
            });

            $('.btn-delete').off('click').on('click', function () {
                const organizationId = $(this).data('organization-id');
                deleteOrganization(organizationId);
            });
        }

        function updateTableInfo(settings) {
            const info = organizationsTable.page.info();

            if (info.recordsTotal > 0) {
                $('#tableInfo').html(`نمایش ${info.start + 1} تا ${info.end} از ${info.recordsTotal} ردیف`);
                $('#organizationCount').text(info.recordsTotal);
            } else {
                $('#tableInfo').html('هیچ رکوردی یافت نشد');
                $('#organizationCount').text('0');
            }
        }

        function updatePagination(settings) {
            const info = organizationsTable.page.info();
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
                        class="px-3 py-2 text-sm font-medium transition-colors duration-200 border ${isActive ? 'text-purple-600 bg-purple-50 border-purple-300' : 'text-gray-500 bg-white border-gray-300 hover:text-gray-700 hover:bg-gray-50'}">
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
            organizationsTable.page(pageNumber).draw('page');
        }

        function updateStats() {
            // This would typically fetch stats from an API endpoint
            $('#totalOrganizations').text($('#organizationCount').text() || '0');
            $('#activeOrganizations').text('0'); // Would be calculated from API
            $('#pendingOrganizations').text('0'); // Would be calculated from API
        }

        function refreshTable() {
            organizationsTable.ajax.reload(null, false);
            updateStats();
            showToast('جدول با موفقیت بروزرسانی شد', 'success');
        }

        function exportData() {
            window.location.href = '{{ route("panel.organizations.export") }}?format=excel';
            showToast('درحال تهیه فایل Excel...', 'info');
        }

        // Modal functions
        function openCreateModal() {
            $('#createModal').removeClass('hidden').addClass('flex');
            $('#createModalBody').html(`
                <div class="flex items-center justify-center py-12">
                    <div class="text-center">
                        <div class="w-16 h-16 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                        <p class="text-gray-500">در حال بارگذاری فرم...</p>
                    </div>
                </div>
            `);

            $.get('{{ route("panel.organizations.create") }}')
                .done(function (response) {
                    if (response.success) {
                        $('#createModalBody').html(response.html);
                        bindFormEvents('#createForm');
                    }
                })
                .fail(function () {
                    showToast('خطا در بارگذاری فرم', 'error');
                    closeCreateModal();
                });
        }

        function closeCreateModal() {
            $('#createModal').removeClass('flex').addClass('hidden');
        }

        function editOrganization(organizationId) {
            currentOrganizationId = organizationId;
            $('#editModal').removeClass('hidden').addClass('flex');
            $('#editModalBody').html(`
                <div class="flex items-center justify-center py-12">
                    <div class="text-center">
                        <div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                        <p class="text-gray-500">در حال بارگذاری اطلاعات...</p>
                    </div>
                </div>
            `);

            $.get(`{{ route('panel.organizations.index') }}/${organizationId}/edit`)
                .done(function (response) {
                    if (response.success) {
                        $('#editModalBody').html(response.html);
                        bindFormEvents('#editForm');
                    }
                })
                .fail(function () {
                    showToast('خطا در بارگذاری اطلاعات', 'error');
                    closeEditModal();
                });
        }

        function closeEditModal() {
            $('#editModal').removeClass('flex').addClass('hidden');
            currentOrganizationId = null;
        }

        function showOrganization(organizationId) {
            $('#showModal').removeClass('hidden').addClass('flex');
            $('#showModalBody').html(`
                <div class="flex items-center justify-center py-12">
                    <div class="text-center">
                        <div class="w-16 h-16 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                        <p class="text-gray-500">در حال بارگذاری اطلاعات...</p>
                    </div>
                </div>
            `);

            $.get(`{{ route('panel.organizations.index') }}/${organizationId}`)
                .done(function (response) {
                    if (response.success) {
                        $('#showModalBody').html(response.html);
                    }
                })
                .fail(function () {
                    showToast('خطا در بارگذاری اطلاعات', 'error');
                    closeShowModal();
                });
        }

        function closeShowModal() {
            $('#showModal').removeClass('flex').addClass('hidden');
        }

        function deleteOrganization(organizationId) {
            currentOrganizationId = organizationId;
            $('#deleteModal').removeClass('hidden').addClass('flex');
        }

        function closeDeleteModal() {
            $('#deleteModal').removeClass('flex').addClass('hidden');
            currentOrganizationId = null;
        }

        function confirmDelete() {
            if (!currentOrganizationId) return;

            $.ajax({
                url: `{{ route('panel.organizations.index') }}/${currentOrganizationId}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        closeDeleteModal();
                        organizationsTable.ajax.reload(null, false);
                        showToast(response.message, 'success');
                    }
                },
                error: function () {
                    showToast('خطا در حذف اطلاعات', 'error');
                }
            });
        }

        function bindFormEvents(formSelector) {
            $(formSelector).off('submit').on('submit', function (e) {
                e.preventDefault();
                submitForm(this);
            });
        }

        function submitForm(form) {
            const $form = $(form);
            const formData = new FormData(form);
            const isEdit = $form.attr('id') === 'editForm';
            const url = isEdit ?
                `{{ route('panel.organizations.index') }}/${currentOrganizationId}` :
                '{{ route("panel.organizations.store") }}';

            if (isEdit) {
                formData.append('_method', 'PUT');
            }

            const submitBtn = $form.find('button[type="submit"]');
            const originalText = submitBtn.html();

            submitBtn.prop('disabled', true).html(`
                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                در حال ارسال...
            `);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        if (isEdit) {
                            closeEditModal();
                        } else {
                            closeCreateModal();
                        }
                        organizationsTable.ajax.reload(null, false);
                        showToast(response.message, 'success');
                    }
                },
                error: function (xhr) {
                    handleFormErrors(xhr);
                },
                complete: function () {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
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
                $('body').append('<div id="toastContainer" class="fixed bottom-5 left-5 space-y-3" style="z-index: 999999999 !important;"></div>');
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

        // Add CSRF token to meta if not present
        if (!$('meta[name="csrf-token"]').attr('content')) {
            $('head').append('<meta name="csrf-token" content="{{ csrf_token() }}">');
        }
    </script>
@endpush
