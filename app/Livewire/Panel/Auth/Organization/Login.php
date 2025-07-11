<?php

namespace App\Livewire\Panel\Auth\Organization;

use App\Models\OrganizationUser;
use App\Models\Role;
use App\Models\User;
use App\Services\SMS\smsService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;

class Login extends Component
{
    #[Validate]
    public string $national_id;
    #[Validate]
    public string $phone_number;
    #[Validate]
    public string $code;

    public function rules()
    {
        return [
            'national_id' => ['required', new ValidNationalCard()],
            'phone_number' => ['required', new ValidPhoneNumber()],
            'code' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'این فیلد باید حتما وارد شود.'
        ];
    }

    #[On('send-sms')]
    public function sendSMS()
    {
        $this->validate([
            'national_id' => ['required', new ValidNationalCard()],
            'phone_number' => ['required', new ValidPhoneNumber()],
        ]);

        $organization = OrganizationUser::query()->where([
            'national_id' => $this->national_id,
            'phone_number' => $this->phone_number,
        ])->first();
        $user = $organization->user;

        if ($user && $user->hasRole(Role::ORGANIZATION_ROLE)) {
            $code = smsService::generateCode($user->id);
            $result = smsService::sendSMS($user->getPhone(), $code);
            if ($result) {
                $this->dispatch('start-interval');
                toastr()->success('کد ورود با موفقیت ارسال شد.', 'موفق');
            } else {
                toastr()->error('خطا در ارسال کد. دوباره تلاش کنید یا با پشتیبانی در ارتباط باشید', 'خطا');
            }
        } else {
            $this->addError('national_id', 'کد ملی یا شماره همراه صحیح نیست.');
            $this->addError('phone_number', 'کد ملی یا شماره همراه صحیح نیست.');
        }
    }

    public function login()
    {
        try {
            $this->validate();

            $organization = OrganizationUser::query()->where([
                'national_id' => $this->national_id,
                'phone_number' => $this->phone_number,
            ])->first();
            $user = $organization->user;

            if ($user && $user->hasRole(Role::ORGANIZATION_ROLE)) {
                $status = smsService::checkCode($user->id, $this->code);
                if ($status) {
                    Auth::login($user);

                    return redirect()->route('panel.home');
                } else {
                    $this->addError('code', 'کد نامعتبر است.');
                }
            } else {
                $this->addError('national_id', 'کد ملی یا شماره همراه صحیح نیست.');
                $this->addError('phone_number', 'کد ملی یا شماره همراه صحیح نیست.');
            }
        } catch (Exception $e) {
            toastr()->error('خطای سرور، دوباره تلاش کنید');
        }
    }

    #[Layout('livewire.panel.auth.layouts.app')]
    public function render()
    {
        return view('livewire.panel.auth.organization.login');
    }
}
