@extends('layouts.app')

@section('title', 'تنظیمات درباره ما')

@section('content')
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center ml-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 19h-6a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1h6a2 2 0 0 1 2 2a2 2 0 0 1 2 -2h6a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-6a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2z M12 5v16 M7 7h1 M7 11h1 M16 7h1 M16 11h1 M16 15h1"/>
                            </svg>
                        </div>
                        تنظیمات درباره ما
                    </h1>
                    <p class="text-gray-600 mt-1">مدیریت محتوا و تصاویر صفحه درباره ما</p>
                </div>
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    @can(\App\Models\AboutUs::ABOUT_US_EDIT)
                        <button onclick="openEditModal()"
                                class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            ویرایش محتوا
                        </button>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Content Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">محتوای فعلی</h2>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <div class="w-1.5 h-1.5 rounded-full bg-green-500 ml-1.5"></div>
                            منتشر شده
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2"
                                id="current-title">{{ $aboutUs->title }}</h3>
                        </div>

                        <div class="prose prose-gray max-w-none">
                            <div id="content-display" class="text-gray-700 leading-relaxed">
                                {!! $aboutUs->description !!}
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span
                                id="last-updated">آخرین بروزرسانی: {{ $aboutUs->updated_at?->diffForHumans() ?? 'نامشخص' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <!-- Image Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">تصویر اصلی</h3>
                    <div class="space-y-4">
                        <div class="aspect-video rounded-xl overflow-hidden bg-gray-100">
                            <img id="sidebar-image"
                                 src="{{ $aboutUs->image ? asset($aboutUs->image) : 'https://placehold.co/400x225/EEE/31343C?text=تصویر+یافت+نشد' }}"
                                 alt="{{ $aboutUs->title }}"
                                 class="w-full h-full object-cover">
                        </div>
                        @if($aboutUs->image)
                            <div class="text-xs text-gray-500" id="image-info">
                                <div class="flex items-center justify-between">
                                    <span>فرمت: {{ pathinfo($aboutUs->image, PATHINFO_EXTENSION) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-gradient-to-r from-teal-500 to-cyan-600 rounded-2xl p-6 text-white">
                    <h3 class="text-lg font-semibold mb-4">آمار محتوا</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-teal-100">تعداد کلمات:</span>
                            <span class="font-semibold"
                                  id="word-count">{{ str_word_count(strip_tags($aboutUs->description)) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-teal-100">تعداد کاراکتر:</span>
                            <span class="font-semibold"
                                  id="char-count">{{ strlen(strip_tags($aboutUs->description)) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-teal-100">وضعیت تصویر:</span>
                            <span class="font-semibold" id="image-status">
                                {{ $aboutUs->image ? 'موجود' : 'ندارد' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can(\App\Models\AboutUs::ABOUT_US_EDIT)
        <!-- Edit Modal -->
        <div id="editModal"
             class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-5xl w-full max-h-[95vh] overflow-hidden">
                <!-- Modal Header -->
                <div
                    class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-teal-500 to-cyan-600">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white">ویرایش محتوای درباره ما</h3>
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
                <div class="p-6 overflow-y-auto max-h-[calc(95vh-140px)]" id="modalBody">
                    <form id="aboutUsForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                            <!-- Main Form -->
                            <div class="lg:col-span-3 space-y-6">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                        عنوان
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           id="title"
                                           name="title"
                                           value="{{ $aboutUs->title }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white text-gray-900 transition-all duration-200"
                                           placeholder="عنوان صفحه درباره ما"
                                           required>
                                    <p class="mt-1 text-xs text-gray-500">عنوان اصلی صفحه درباره ما که در بالای صفحه
                                        نمایش داده می‌شود</p>
                                </div>

                                <!-- Description -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                        محتوا
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="description"
                                              name="description"
                                              rows="20"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white text-gray-900 transition-all duration-200"
                                              placeholder="محتوای صفحه درباره ما را اینجا بنویسید..."
                                              required>{{ $aboutUs->description }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500">متن کامل صفحه درباره ما با امکان فرمت‌بندی</p>
                                </div>
                            </div>

                            <!-- Image Upload Sidebar -->
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">
                                        تصویر اصلی
                                    </label>

                                    <!-- Current Image -->
                                    <div class="mb-4">
                                        <p class="text-xs text-gray-600 mb-2">تصویر فعلی:</p>
                                        <div
                                            class="aspect-video rounded-xl overflow-hidden bg-gray-100 border-2 border-dashed border-gray-300">
                                            <img id="currentImage"
                                                 src="{{ $aboutUs->image ? asset($aboutUs->image) : 'https://placehold.co/400x225/EEE/31343C?text=تصویر+یافت+نشد' }}"
                                                 alt="تصویر فعلی"
                                                 class="w-full h-full object-cover">
                                        </div>
                                    </div>

                                    <!-- Upload New Image -->
                                    <div class="relative">
                                        <input type="file"
                                               id="image"
                                               name="image"
                                               accept="image/*"
                                               class="hidden"
                                               onchange="previewImage(this)">
                                        <label for="image"
                                               class="flex flex-col items-center justify-center w-full p-4 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 4v16m8-8H4"/>
                                            </svg>
                                            <p class="text-sm text-gray-600 text-center">
                                                <span class="font-semibold">کلیک کنید</span><br>
                                                یا فایل را بکشید
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF تا 5MB</p>
                                        </label>
                                    </div>

                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="hidden mt-4">
                                        <p class="text-xs text-gray-600 mb-2">تصویر جدید:</p>
                                        <div
                                            class="aspect-video rounded-xl overflow-hidden bg-gray-100 border border-gray-300">
                                            <img id="previewImg" src="" alt="پیش‌نمایش"
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <button type="button"
                                                onclick="removeImagePreview()"
                                                class="mt-2 text-sm text-red-600 hover:text-red-800 transition-colors duration-200">
                                            حذف تصویر جدید
                                        </button>
                                    </div>
                                </div>

                                <!-- Image Guidelines -->
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                                        <svg class="w-4 h-4 ml-2 text-gray-500" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        راهنمای تصویر
                                    </h4>
                                    <ul class="text-xs text-gray-600 space-y-1.5">
                                        <li class="flex items-start">
                                            <span class="text-teal-500 font-bold ml-2">•</span>
                                            حداکثر حجم: 5 مگابایت
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-teal-500 font-bold ml-2">•</span>
                                            فرمت‌های مجاز: JPG, PNG, GIF, WebP
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-teal-500 font-bold ml-2">•</span>
                                            نسبت پیشنهادی: 16:9
                                        </li>
                                        <li class="flex items-start">
                                            <span class="text-teal-500 font-bold ml-2">•</span>
                                            رزولوشن پیشنهادی: 1200×675 پیکسل
                                        </li>
                                    </ul>
                                </div>

                                <!-- Upload Progress -->
                                <div id="uploadProgress" class="hidden">
                                    <div class="bg-blue-50 rounded-xl p-4">
                                        <div class="flex items-center mb-2">
                                            <svg class="w-4 h-4 text-blue-500 ml-2" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                            <span class="text-sm font-medium text-blue-700">در حال آپلود...</span>
                                        </div>
                                        <div class="w-full bg-blue-200 rounded-full h-2">
                                            <div id="progressBar"
                                                 class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                                                 style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-between items-center pt-6 mt-6 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Ctrl+S برای ذخیره سریع | Escape برای بستن</span>
                            </div>

                            <div class="flex space-x-3 rtl:space-x-reverse">
                                <button type="button"
                                        onclick="closeEditModal()"
                                        class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 font-medium">
                                    انصراف
                                </button>
                                <button type="submit"
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                    ذخیره تغییرات
                                    <div class="mr-2 opacity-0 transition-opacity duration-200" id="submitLoading">
                                        <div
                                            class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

@endsection

@push('styles')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable {
            min-height: 400px;
            max-height: 500px;
        }

        .ck.ck-content {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            direction: rtl;
            text-align: right;
            line-height: 1.6;
        }

        .ck.ck-content ul {
            list-style-type: disc;
            margin-right: 20px;
            margin-bottom: 16px;
        }

        .ck.ck-content ol {
            list-style-type: decimal;
            margin-right: 20px;
            margin-bottom: 16px;
        }

        .ck.ck-content li {
            margin-bottom: 4px;
        }

        .ck.ck-content a {
            color: #0d9488;
            text-decoration: underline;
        }

        .ck.ck-content blockquote {
            border-right: 4px solid #e5e7eb;
            padding-right: 16px;
            margin: 16px 0;
            font-style: italic;
            color: #6b7280;
            background-color: #f9fafb;
            padding: 16px;
            border-radius: 8px;
        }

        .ck.ck-content h1, .ck.ck-content h2, .ck.ck-content h3,
        .ck.ck-content h4, .ck.ck-content h5, .ck.ck-content h6 {
            font-weight: 600;
            margin-top: 24px;
            margin-bottom: 12px;
        }

        .ck.ck-content p {
            margin-bottom: 16px;
        }

        /* Prose styles for content display */
        #content-display ul {
            list-style-type: disc;
            margin-right: 20px;
            margin-bottom: 16px;
        }

        #content-display ol {
            list-style-type: decimal;
            margin-right: 20px;
            margin-bottom: 16px;
        }

        #content-display li {
            margin-bottom: 4px;
        }

        #content-display a {
            color: #0d9488;
            text-decoration: underline;
        }

        #content-display blockquote {
            border-right: 4px solid #e5e7eb;
            padding-right: 16px;
            margin: 16px 0;
            font-style: italic;
            color: #6b7280;
            background-color: #f9fafb;
            padding: 16px;
            border-radius: 8px;
        }

        #content-display h1, #content-display h2, #content-display h3,
        #content-display h4, #content-display h5, #content-display h6 {
            font-weight: 600;
            margin-bottom: 12px;
            margin-top: 24px;
        }

        #content-display h1 {
            font-size: 2rem;
        }

        #content-display h2 {
            font-size: 1.75rem;
        }

        #content-display h3 {
            font-size: 1.5rem;
        }

        #content-display h4 {
            font-size: 1.25rem;
        }

        #content-display h5 {
            font-size: 1.125rem;
        }

        #content-display h6 {
            font-size: 1rem;
        }

        #content-display p {
            margin-bottom: 16px;
            line-height: 1.7;
        }

        #content-display strong {
            font-weight: 600;
        }

        #content-display em {
            font-style: italic;
        }

        #content-display code {
            background-color: #f3f4f6;
            padding: 2px 4px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
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

        /* Loading animations */
        .loading-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .5;
            }
        }

        /* Drag and drop styles */
        .drag-over {
            border-color: #0d9488 !important;
            background-color: #f0fdfa !important;
        }

        /* Scrollbar styles */
        #modalBody::-webkit-scrollbar {
            width: 6px;
        }

        #modalBody::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        #modalBody::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        #modalBody::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        let editor;
        let hasUnsavedChanges = false;
        let originalTitle = '';
        let originalDescription = '';

        document.addEventListener('DOMContentLoaded', function () {
            // Store original values
            originalTitle = document.getElementById('title')?.value || '';
            originalDescription = `{{ $aboutUs->description }}`;

            // Setup drag and drop
            setupDragAndDrop();
        });

        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
            document.body.style.overflow = 'hidden';

            // Initialize CKEditor
            initializeCKEditor();

            // Bind form events
            bindFormEvents();

            // Reset unsaved changes flag
            hasUnsavedChanges = false;
        }

        function closeEditModal() {
            if (hasUnsavedChanges) {
                if (!confirm('تغییرات ذخیره نشده از بین خواهد رفت. آیا مطمئن هستید؟')) {
                    return;
                }
            }

            document.getElementById('editModal').classList.remove('flex');
            document.getElementById('editModal').classList.add('hidden');
            document.body.style.overflow = '';

            // Destroy CKEditor
            if (editor) {
                editor.destroy();
                editor = null;
            }

            // Reset form
            resetForm();
            hasUnsavedChanges = false;
        }

        function initializeCKEditor() {
            if (editor) {
                editor.destroy();
            }

            ClassicEditor
                .create(document.querySelector('#description'), {
                    language: 'fa',
                    toolbar: {
                        items: [
                            'heading',
                            '|',
                            'bold',
                            'italic',
                            'underline',
                            'strikethrough',
                            '|',
                            'bulletedList',
                            'numberedList',
                            '|',
                            'alignment',
                            '|',
                            'link',
                            'blockQuote',
                            'insertTable',
                            'codeBlock',
                            '|',
                            'undo',
                            'redo'
                        ]
                    },
                    heading: {
                        options: [
                            {model: 'paragraph', title: 'پاراگراف', class: 'ck-heading_paragraph'},
                            {model: 'heading1', view: 'h1', title: 'عنوان 1', class: 'ck-heading_heading1'},
                            {model: 'heading2', view: 'h2', title: 'عنوان 2', class: 'ck-heading_heading2'},
                            {model: 'heading3', view: 'h3', title: 'عنوان 3', class: 'ck-heading_heading3'},
                            {model: 'heading4', view: 'h4', title: 'عنوان 4', class: 'ck-heading_heading4'}
                        ]
                    },
                    alignment: {
                        options: ['left', 'center', 'right', 'justify']
                    },
                    table: {
                        contentToolbar: [
                            'tableColumn',
                            'tableRow',
                            'mergeTableCells',
                            'tableProperties',
                            'tableCellProperties'
                        ]
                    },
                    codeBlock: {
                        languages: [
                            {language: 'javascript', label: 'JavaScript'},
                            {language: 'php', label: 'PHP'},
                            {language: 'python', label: 'Python'},
                            {language: 'css', label: 'CSS'},
                            {language: 'html', label: 'HTML'}
                        ]
                    }
                })
                .then(newEditor => {
                    editor = newEditor;

                    // Track changes
                    editor.model.document.on('change:data', () => {
                        hasUnsavedChanges = true;
                        updateWordCount();
                    });
                })
                .catch(error => {
                    console.error('Error initializing CKEditor:', error);
                    showToast('خطا در بارگذاری ویرایشگر متن', 'error');
                });
        }

        function bindFormEvents() {
            const form = document.getElementById('aboutUsForm');
            const titleInput = document.getElementById('title');

            // Track title changes
            titleInput.addEventListener('input', () => {
                hasUnsavedChanges = true;
            });

            // Handle form submission
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                updateAboutUs();
            });
        }

        function updateAboutUs() {
            const form = document.getElementById('aboutUsForm');
            const submitBtn = form.querySelector('button[type="submit"]');
            const loading = document.getElementById('submitLoading');

            // Validate form
            if (!validateForm()) {
                return;
            }

            submitBtn.disabled = true;
            loading.classList.remove('opacity-0');

            const formData = new FormData(form);

            // Get content from CKEditor
            if (editor) {
                formData.set('description', editor.getData());
            }

            $.ajax({
                url: '{{ route("panel.about.us.update") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function () {
                    const xhr = new window.XMLHttpRequest();
                    // Upload progress
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            const percentComplete = evt.loaded / evt.total * 100;
                            updateUploadProgress(percentComplete);
                        }
                    }, false);
                    return xhr;
                },
                success: function (response) {
                    if (response.success) {
                        showToast(response.message, 'success');
                        hasUnsavedChanges = false;

                        // Update page content
                        updatePageContent(response.data);

                        setTimeout(() => {
                            closeEditModal();
                        }, 1000);
                    }
                },
                error: function (xhr) {
                    handleFormErrors(xhr);
                },
                complete: function () {
                    submitBtn.disabled = false;
                    loading.classList.add('opacity-0');
                    hideUploadProgress();
                }
            });
        }

        function validateForm() {
            const title = document.getElementById('title').value.trim();
            let description = '';

            if (editor) {
                description = editor.getData().trim();
            }

            if (!title) {
                showToast('عنوان الزامی است', 'error');
                document.getElementById('title').focus();
                return false;
            }

            if (title.length < 2) {
                showToast('عنوان باید حداقل 2 کاراکتر باشد', 'error');
                document.getElementById('title').focus();
                return false;
            }

            if (!description || description === '<p></p>' || description === '<p><br></p>') {
                showToast('محتوا الزامی است', 'error');
                if (editor) {
                    editor.editing.view.focus();
                }
                return false;
            }

            if (description.length < 10) {
                showToast('محتوا باید حداقل 10 کاراکتر باشد', 'error');
                if (editor) {
                    editor.editing.view.focus();
                }
                return false;
            }

            // Validate image if selected
            const imageInput = document.getElementById('image');
            if (imageInput.files.length > 0) {
                const file = imageInput.files[0];
                const maxSize = 5 * 1024 * 1024; // 5MB
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

                if (file.size > maxSize) {
                    showToast('حجم تصویر نباید بیشتر از 5 مگابایت باشد', 'error');
                    return false;
                }

                if (!allowedTypes.includes(file.type)) {
                    showToast('فرمت تصویر مجاز نیست. لطفا JPG، PNG، GIF یا WebP استفاده کنید', 'error');
                    return false;
                }
            }

            return true;
        }

        function updatePageContent(data) {
            // Update title
            if (data.title) {
                document.getElementById('current-title').textContent = data.title;
            }

            // Update content
            if (data.description) {
                document.getElementById('content-display').innerHTML = data.description;
                updateStats(data.description);
            }

            // Update image if changed
            if (data.image_url) {
                document.getElementById('sidebar-image').src = data.image_url;
                document.getElementById('image-status').textContent = 'موجود';
            }

            // Update last updated time
            document.getElementById('last-updated').textContent = 'آخرین بروزرسانی: همین الان';
        }

        function updateStats(description) {
            const plainText = description.replace(/<[^>]*>/g, '');
            const wordCount = plainText.split(/\s+/).filter(word => word.length > 0).length;
            const charCount = plainText.length;

            document.getElementById('word-count').textContent = wordCount;
            document.getElementById('char-count').textContent = charCount;
        }

        function updateWordCount() {
            if (editor) {
                const content = editor.getData();
                updateStats(content);
            }
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Validate file
                const maxSize = 5 * 1024 * 1024; // 5MB
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

                if (file.size > maxSize) {
                    showToast('حجم تصویر نباید بیشتر از 5 مگابایت باشد', 'error');
                    input.value = '';
                    return;
                }

                if (!allowedTypes.includes(file.type)) {
                    showToast('فرمت تصویر مجاز نیست', 'error');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                    hasUnsavedChanges = true;
                };

                reader.readAsDataURL(file);
            }
        }

        function removeImagePreview() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
            document.getElementById('previewImg').src = '';
            hasUnsavedChanges = true;
        }

        function setupDragAndDrop() {
            const dropZone = document.querySelector('label[for="image"]');
            const fileInput = document.getElementById('image');

            if (dropZone && fileInput) {
                dropZone.addEventListener('dragover', function (e) {
                    e.preventDefault();
                    dropZone.classList.add('drag-over');
                });

                dropZone.addEventListener('dragleave', function (e) {
                    e.preventDefault();
                    dropZone.classList.remove('drag-over');
                });

                dropZone.addEventListener('drop', function (e) {
                    e.preventDefault();
                    dropZone.classList.remove('drag-over');

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        fileInput.files = files;
                        previewImage(fileInput);
                    }
                });
            }
        }

        function updateUploadProgress(percent) {
            const progressContainer = document.getElementById('uploadProgress');
            const progressBar = document.getElementById('progressBar');

            progressContainer.classList.remove('hidden');
            progressBar.style.width = percent + '%';
        }

        function hideUploadProgress() {
            setTimeout(() => {
                document.getElementById('uploadProgress').classList.add('hidden');
                document.getElementById('progressBar').style.width = '0%';
            }, 1000);
        }

        function resetForm() {
            // Reset form fields
            document.getElementById('title').value = originalTitle;

            // Reset image preview
            document.getElementById('imagePreview').classList.add('hidden');
            document.getElementById('image').value = '';

            // Reset CKEditor content will be handled when modal opens again
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
                const message = xhr.responseJSON?.message || 'خطا در ثبت اطلاعات';
                showToast(message, 'error');
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
                success: 'text-green-500 bg-green-100 border-green-500',
                error: 'text-red-500 bg-red-100 border-red-500',
                info: 'text-blue-500 bg-blue-100 border-blue-500'
            };

            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = `flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-lg transform translate-x-full transition-all duration-300 border-l-4 ${colorMap[type]}`;
            toast.setAttribute('role', 'alert');

            toast.innerHTML = `
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${colorMap[type].split(' ')[1]} ${colorMap[type].split(' ')[0]}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        ${iconMap[type]}
                    </svg>
                </div>
                <div class="mr-3 text-sm font-normal">${message}</div>
                <button type="button" onclick="removeToast('${toastId}')" class="mr-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 transition-colors duration-200">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            // Create toast container if it doesn't exist
            let container = document.getElementById('toastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toastContainer';
                container.className = 'fixed bottom-5 left-5 z-50 space-y-3';
                document.body.appendChild(container);
            }

            container.appendChild(toast);

            setTimeout(() => toast.classList.remove('translate-x-full'), 100);
            setTimeout(() => removeToast(toastId), 5000);
        }

        function removeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function (e) {
            // Escape to close modal
            if (e.key === 'Escape') {
                if (document.getElementById('editModal').classList.contains('flex')) {
                    closeEditModal();
                }
            }

            // Ctrl+S to save (prevent default browser save)
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                if (document.getElementById('editModal').classList.contains('flex')) {
                    updateAboutUs();
                }
            }
        });

        // Warn before leaving with unsaved changes
        window.addEventListener('beforeunload', function (e) {
            if (hasUnsavedChanges) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // Close modal on backdrop click
        document.getElementById('editModal')?.addEventListener('click', function (e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Add CSRF token to meta if not present
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.name = 'csrf-token';
            meta.content = '{{ csrf_token() }}';
            document.head.appendChild(meta);
        }

        // Setup AJAX headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endpush
