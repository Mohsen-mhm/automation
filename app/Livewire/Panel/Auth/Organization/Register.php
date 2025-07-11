<?php

namespace App\Livewire\Panel\Auth\Organization;

use App\Models\Config;
use App\Models\OrganizationUser;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Milwad\LaravelValidate\Rules\ValidIranPostalCode;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;
use Illuminate\Support\Str;

class Register extends Component
{
    use WithFileUploads;

    public string $fname = '';
    public string $lname = '';
    public string $national_id = '';
    public string $organization_name = '';
    public string $organization_level = '';
    public $national_card;
    public $personnel_card;
    public $introduction_letter;
    public string $province = '';
    public string $city = '';
    public string $address = '';
    public string $postal = '';
    public string $landline_number = '';
    public string $phone_number = '';


    public function rules()
    {
        return [
            'fname' => ['required', 'string', 'min:2', 'max:150'],
            'lname' => ['required', 'string', 'min:2', 'max:150'],
            'national_id' => ['required', 'string', 'unique:organization_users,national_id', new ValidNationalCard()],
            'organization_name' => ['required', 'string'],
            'organization_level' => ['required', 'string'],
            'national_card' => ['required', 'image'],
            'personnel_card' => ['required', 'image'],
            'introduction_letter' => ['required', 'image'],
            'province' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'postal' => ['required', 'string'],
            'landline_number' => ['nullable', 'string'],
            'phone_number' => ['required', 'string'],
        ];
    }

    public function register()
    {
        $validData = $this->validate();

        $validData['national_card'] = $this->uploadNationalImage($validData['national_card']);
        $validData['personnel_card'] = $this->uploadPersonnelImage($validData['personnel_card']);
        $validData['introduction_letter'] = $this->uploadIntroductionImage($validData['introduction_letter']);

        DB::beginTransaction();
        try {
            $user = User::query()->create(
                [
                    'name' => $validData['fname'] . ' ' . $validData['lname'],
                    'national_id' => $validData['national_id'],
                    'phone_number' => $validData['phone_number'],
                ],
            );

            $validData['user_id'] = $user->id;
            OrganizationUser::create($validData);

            $user->roles()->sync(Role::query()->whereName(Role::ORGANIZATION_ROLE)->first()->id);
            DB::commit();

            toastr()->success('اطلاعات شما با موفقیت ارسال شد و به زودی بررسی می شود.', 'موفق');
            return redirect()->route('home');
        } catch (Exception $e) {
            DB::rollback();
            return toastr()->error('خطای سرور در ارسال اطلاعات.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
        }
    }

    private function uploadNationalImage($national_card)
    {
        $imageName = Str::random(20);
        try {
            $path = 'storage/national/' . now()->year . '/' . now()->month . '/' . now()->day;
            $national_card->storeAs($path, $imageName . '.' . $national_card->extension());
            $nationalImageName = $path . '/' . $imageName . '.' . $national_card->extension();
        } catch (\Exception) {
            $nationalImageName = null;
        }

        return $nationalImageName ?: toastr()->error('خطای سرور در اپلود کارت ملی.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
    }

    private function uploadPersonnelImage($personnel_card)
    {
        $imageName = Str::random(20);
        try {
            $path = 'storage/personnel/' . now()->year . '/' . now()->month . '/' . now()->day;
            $personnel_card->storeAs($path, $imageName . '.' . $personnel_card->extension());
            $personnelImageName = $path . '/' . $imageName . '.' . $personnel_card->extension();
        } catch (\Exception) {
            $personnelImageName = null;
        }

        return $personnelImageName ?: toastr()->error('خطای سرور در اپلود کارت پرسنلی.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
    }

    private function uploadIntroductionImage($introduction_letter)
    {
        $imageName = Str::random(20);
        try {
            $path = 'storage/introduction/' . now()->year . '/' . now()->month . '/' . now()->day;
            $introduction_letter->storeAs($path, $imageName . '.' . $introduction_letter->extension());
            $introductionImageName = $path . '/' . $imageName . '.' . $introduction_letter->extension();
        } catch (\Exception) {
            $introductionImageName = null;
        }

        return $introductionImageName ?: toastr()->error('خطای سرور در اپلود معرفی نامه.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
    }

    #[Layout('livewire.panel.auth.layouts.app')]
    public function render()
    {
        return view('livewire.panel.auth.organization.register');
    }
}
