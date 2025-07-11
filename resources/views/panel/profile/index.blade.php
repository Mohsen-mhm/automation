@extends('layouts.app')

@section('title', 'پروفایل کاربری')

@section('content')
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center ml-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        پروفایل کاربری
                    </h1>
                    <p class="text-gray-600 mt-1">مدیریت اطلاعات شخصی و حساب کاربری</p>
                </div>

                <!-- Status Badge -->
                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                    @if($profileData->active ?? false)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            فعال
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            غیرفعال
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    @switch($profileType)
                        @case('company')
                            ویرایش اطلاعات شرکت
                            @break
                        @case('greenhouse')
                            ویرایش اطلاعات گلخانه
                            @break
                        @case('organization')
                            ویرایش اطلاعات سازمانی
                            @break
                    @endswitch
                </h2>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                @if($profileType === 'company')
                    @include('panel.profile.company-form', ['company' => $profileData, 'companyTypes' => $additionalData['companyTypes'], 'provinces' => $additionalData['provinces']])
                @elseif($profileType === 'greenhouse')
                    @include('panel.profile.greenhouse-form', ['greenhouse' => $profileData, 'substrates' => $additionalData['substrates'], 'productTypes' => $additionalData['productTypes'], 'greenhouseStatuses' => $additionalData['greenhouseStatuses'], 'provinces' => $additionalData['provinces']])
                @elseif($profileType === 'organization')
                    @include('panel.profile.organization-form', ['organization' => $profileData, 'provinces' => $additionalData['provinces']])
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            // Province/City handling
            $(document).on('change', '.province-select', function () {
                const provinceId = $(this).val();
                const citySelect = $(this).closest('form').find('.city-select');

                if (provinceId) {
                    loadCities(provinceId, citySelect);
                } else {
                    citySelect.html('<option value="">ابتدا استان را انتخاب کنید</option>');
                }
            });

            // Location link coordinates extraction
            $(document).on('blur', '.location-link', function () {
                const url = $(this).val();
                if (url) {
                    extractCoordinates(url, $(this).closest('form'));
                }
            });
        });

        function loadCities(provinceId, citySelect) {
            citySelect.html('<option value="">در حال بارگذاری...</option>');

            $.get('{{ route("panel.companies.cities") }}', {province_id: provinceId})
                .done(function (response) {
                    if (response.success) {
                        let options = '<option value="">شهر را انتخاب کنید</option>';
                        response.cities.forEach(city => {
                            options += `<option value="${city.name}">${city.name}</option>`;
                        });
                        citySelect.html(options);
                    }
                })
                .fail(function () {
                    citySelect.html('<option value="">خطا در بارگذاری شهرها</option>');
                });
        }

        function extractCoordinates(url, form) {
            const coordinatesDisplay = form.find('.coordinates-display');
            coordinatesDisplay.html('<div class="flex items-center text-gray-500"><div class="w-4 h-4 border-2 border-blue-500 border-t-transparent rounded-full animate-spin ml-2"></div>در حال دریافت مختصات...</div>');

            $.post('{{ route("panel.profile.coordinates") }}', {
                url: url,
                _token: $('meta[name="csrf-token"]').attr('content')
            })
                .done(function (response) {
                    if (response.success) {
                        const coords = response.coordinates;
                        coordinatesDisplay.html(`
                        <p>مختصات: <strong class="text-emerald-600">${coords.coordinates}</strong></p>
                        <p>عرض جغرافیایی: <strong class="text-emerald-600">${coords.latitude}</strong></p>
                        <p>طول جغرافیایی: <strong class="text-emerald-600">${coords.longitude}</strong></p>
                    `);
                    }
                })
                .fail(function () {
                    coordinatesDisplay.html('<p class="text-red-500">خطا در دریافت مختصات</p>');
                });
        }
    </script>
@endpush
