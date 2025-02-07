<div class="w-full p-5 overflow-x-hidden">
    @can(\App\Models\AboutUs::ABOUT_US_EDIT)
        <script src="/assets/js/ckeditor/ckeditor.js" wire:ignore.self></script>
        <div class="flex flex-col items-center justify-center mb-4 mt-8">
            <h3 class="mb-5 text-xl md:text-2xl font-extrabold text-gray-900 mt-5">تنظیمات درباره ما</h3>

            <form class="w-full mx-auto" method="POST" wire:submit="update" enctype="multipart/form-data">
                <div class="flex flex-wrap -m-2">
                    @csrf
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="title" class="leading-7 text-sm text-gray-600">عنوان</label>
                            <input type="text" id="title" name="title" wire:model="title"
                                   class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            @error('title')
                            <p class="mt-2 text-sm text-red-600"><span
                                    class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
                    </div>
                    <div class="p-2 w-full" wire:ignore>
                        <div class="col-span-2">
                            <label for="edit-description"
                                   class="leading-7 text-sm text-gray-600">محتوا:</label>
                            <textarea id="edit-description" rows="4" name="description" wire:model="description"
                                      class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                      placeholder="Service description"></textarea>
                            @error('description')
                            <p class="mt-2 text-sm text-red-600"><span
                                    class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
                    </div>
                    <script>
                        ClassicEditor
                            .create(document.querySelector('#edit-description'), {
                                toolbar: [
                                    'heading', '|',
                                    'bold', 'italic', 'underline', 'strikethrough', '|',
                                    'bulletedList', 'numberedList', '|',
                                    'alignment:left', 'alignment:center', 'alignment:right', 'alignment:justify', '|',
                                    'link', 'blockQuote', 'codeBlock', '|',
                                    'undo', 'redo'
                                ],
                                alignment: {
                                    options: ['left', 'center', 'right', 'justify']
                                },
                                readOnly: false,
                                placeholder: 'محتوای مورد نظر خود را بسازید...',
                                language: 'fa',
                                width: '100%',
                                skin: 'moono',
                                autoParagraph: true,
                                allowedContent: true,
                            }).then(editor => {
                            editor.setData("{!! $description !!}");

                            editor.model.document.on('change:data', () => {
                                @this.
                                set('description', editor.getData());
                            });
                        }).catch(error => {
                            console.error(error);
                        });
                    </script>
                    <div class="w-full flex justify-between items-center">
                        <div class="p-2 w-1/2">
                            <label for="dropzone-file"
                                   class="leading-7 text-sm text-gray-600">تصویر اصلی:</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file"
                                       class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-400 border-dashed rounded-lg cursor-pointer bg-gray-200 hover:bg-gray-300">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">برای آپلود کلیک کنید</span>
                                        </p>
                                    </div>
                                    <input id="dropzone-file" type="file" class="hidden" wire:model="image"/>
                                </label>
                                @error('image')
                                <p class="mt-2 text-sm text-red-600"><span
                                        class="font-medium">{{ $message }}</span></p>
                                @enderror
                            </div>
                        </div>

                        <div class="p-2 w-1/3 flex flex-col justify-start items-start">
                            <label for="dropzone-file"
                                   class="leading-7 text-sm text-gray-600">تصویر فعلی:</label>
                            <img
                                src="{{ $aboutUs->image ? asset('storage/' . $aboutUs->image) : "https://placehold.co/600x400/EEE/31343C" }}"
                                alt="About Us Image"
                                class="w-full h-full rounded-lg"/>
                        </div>
                    </div>
                </div>
                <div class="p-2 w-full">
                    <button type="submit"
                            class="flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg">
                        ارسال
                    </button>
                </div>
            </form>
        </div>
        <style>
            .ck.ck-content {
                height: 250px !important;
            }

            .ck.ck-editor__main ul, #current-description ul {
                list-style-type: disc;
            }

            .ck.ck-editor__main ol, #current-description ol {
                list-style-type: decimal;
            }

            #current-description ul, #current-description ol {
                margin-left: 15px;
            }

            .ck.ck-editor__main a, #current-description a {
                text-decoration: underline;
                color: #126500;
            }

            .ck.ck-editor__editable_inline {
                padding: 0 1.5rem;
            }
        </style>
    @endcan
</div>
