<div class="w-full flex flex-col justify-center items-center pr-7">
    <div
        class="md:w-2/5 mt-10 flex flex-col justify-center items-center p-6 bg-white border border-gray-200 rounded-lg shadow-lg">
        <h5 class="mb-8 text-2xl font-semibold tracking-tight text-gray-900">ورود شرکت ها</h5>
        <form class="w-full mb-2" wire:submit="login">
            <div class="mb-6">
                <label for="national_id" class="block mb-2 text-sm font-medium text-gray-900">نام کاربری
                    (شناسه ملی)</label>
                <input type="text" id="national_id" wire:model.live="national_id"
                    class="bg-gray-50 transition border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                    placeholder="12345678910" required>
                @error('national_id')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span></p>
                @enderror
            </div>
            <div class="mt-7">
                <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900">رمز عبور
                    (تلفن همراه رابط)</label>
                <input type="text" id="phone_number" wire:model.live="phone_number"
                    class="text-left transition bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                    placeholder="09123456789" required>
                @error('phone_number')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span></p>
                @enderror
            </div>
            <div class="mt-7" wire:ignore.self>
                <label for="code-input" class="text-sm font-medium text-gray-900">کد تایید ارسال
                    شده</label>
                <div class="flex items-center mt-2">
                    <button
                        class="cursor-pointer transition flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-white bg-[#258641] border border-gray-400 rounded-s-lg hover:bg-[#215e32] focus:ring-2 focus:outline-none focus:ring-[#258641]"
                        type="button" onclick="sendSMS(this)">
                        ارسال کد ورود
                    </button>
                    <div class="relative w-full">
                        <input type="text" id="code-input" wire:model.blur="code"
                            class="block transition p-2.5 opacity-75 w-full z-20 text-sm text-left text-gray-900 bg-gray-50 rounded-e-lg border-s-0 border border-gray-400 focus:ring-green-500 focus:border-green-500"
                            placeholder="902150" required disabled>
                    </div>
                </div>
                @error('code')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                @enderror
                <script>
                    function sendSMS(button) {
                        let countdown = 60;
                        codeEl = document.querySelector('#code-input');
                        Livewire.dispatch('send-sms');

                        Livewire.on('start-interval', () => {
                            let interval = setInterval(() => {
                                countdown--;
                                button.innerHTML = countdown + ' ثانیه';
                                button.setAttribute('disabled', '');
                                codeEl.classList.remove('opacity-75');
                                codeEl.removeAttribute('disabled');

                                if (countdown == 0) {
                                    clearInterval(interval);
                                    button.innerHTML = 'ارسال مجدد کد';
                                    button.removeAttribute('disabled');
                                }
                            }, 1000);
                        });

                    }
                </script>
            </div>
            <div class="w-full flex justify-center items-center mt-8">
                <button type="submit"
                    class="focus:outline-none text-white font-bold bg-[#258641] hover:bg-[#215e32] focus:ring-4 focus:ring-green-300 rounded-lg px-5 py-2.5 me-2 mb-2 transition">ورود
                    به پنل</button>
            </div>
        </form>
    </div>
    <div class="w-full flex justify-center items-center mt-8">
        <a href="{{ route('home') }}"
            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 transition">
            بازگشت به صفحه اصلی
        </a>
        <a href="{{ route('register.company') }}"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none transition">
            شرکت جدید
        </a>
    </div>
</div>
