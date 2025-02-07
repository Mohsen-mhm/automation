<x-modal>
    <x-slot name="name">
        show-modal
    </x-slot>

    <x-slot name="title">
        تماس با ما
    </x-slot>

    <x-slot name="content">
        <div class="w-full overflow-y-scroll">
            <div class="overflow-hidden p-3">
                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">نام</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($contactUs)
                            <p wire:transition>{{ $contactUs->get('name') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">نام</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($contactUs)
                            <p wire:transition>{{ $contactUs->get('email') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">نام</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($contactUs)
                            <p wire:transition>{{ $contactUs->get('subject') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">نام</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($contactUs)
                            <p wire:transition>{{ $contactUs->get('message') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </x-slot>
</x-modal>
