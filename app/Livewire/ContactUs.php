<?php

namespace App\Livewire;

use App\Models\ContactUs as ContactUsModel;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ContactUs extends Component
{
    public string|null $name;
    public string|null $email;
    public string|null $phone;
    public string|null $subject;
    public string|null $message;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:2', 'max:1000'],
        ];
    }

    public function submit()
    {
        $validated = $this->validate();
        DB::beginTransaction();
        try {
            ContactUsModel::query()->create($validated);

            toastr()->success('پیغام شما با موفقیت ارسال شد و به زودی بررسی می شود.', 'موفق');
            DB::commit();
            return redirect()->route('contact.us');
        } catch (Exception $exception) {
            DB::rollBack();
            return toastr()->error('خطای سرور در ارسال اطلاعات.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
        }
    }

    #[Layout('livewire.panel.auth.layouts.app')]
    public function render()
    {
        return view('livewire.contact-us');
    }
}
