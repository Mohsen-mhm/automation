<x-modal>
    <x-slot name="name">
        delete-modal
    </x-slot>

    <x-slot name="title">
        حذف گلخانه
    </x-slot>

    <x-slot name="content">
        <form class="p-4 md:p-5" wire:submit="destroy">
            @csrf
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-500 w-12 h-12" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-700">آیا از حذف این گلخانه اطمینان دارید؟</h3>
                <button
                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                    <span>بله</span>
                </button>
                <button data-modal-hide="delete-modal" type="button"
                        class="text-gray-700 bg-white hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-400 rounded-lg border border-gray-400 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                    خیر
                </button>
            </div>
        </form>
    </x-slot>
</x-modal>
