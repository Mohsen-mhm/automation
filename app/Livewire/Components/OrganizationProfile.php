<?php

namespace App\Livewire\Components;

use App\Models\Greenhouse;
use App\Models\OrganizationUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Milwad\LaravelValidate\Rules\ValidIranPostalCode;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;

class OrganizationProfile extends Component
{
    use WithFileUploads;

    public $organization;

    public string $fname = '';
    public string $lname = '';
    public string $national_id = '';
    public string $organization_name = '';
    public string $organization_level = '';
    public $old_national_card;
    public $old_personnel_card;
    public $old_introduction_letter;
    public $national_card;
    public $personnel_card;
    public $introduction_letter;

    public string $province = '';
    public string $city = '';
    public string $address = '';
    public string $postal = '';
    public string $landline_number = '';
    public string $phone_number = '';

    public function mount()
    {
        $this->organization = collect(OrganizationUser::query()->where([
            'national_id' => auth()->user()->getNationalId(),
            'phone_number' => auth()->user()->getPhone()
        ])->first());

        $this->fname = $this->organization->get('fname');
        $this->lname = $this->organization->get('lname');
        $this->national_id = $this->organization->get('national_id');
        $this->organization_name = $this->organization->get('organization_name');
        $this->organization_level = $this->organization->get('organization_level');
        $this->old_national_card = $this->organization->get('national_card');
        $this->old_personnel_card = $this->organization->get('personnel_card');
        $this->old_introduction_letter = $this->organization->get('introduction_letter');
        $this->province = $this->organization->get('province');
        $this->city = $this->organization->get('city');
        $this->address = $this->organization->get('address');
        $this->postal = $this->organization->get('postal');
        $this->landline_number = $this->organization->get('landline_number');
        $this->phone_number = $this->organization->get('phone_number');
    }

    public function rules()
    {
        return [
            'fname' => ['required', 'string', 'min:2', 'max:150'],
            'lname' => ['required', 'string', 'min:2', 'max:150'],
            'national_id' => ['required', 'string', Rule::unique('organization_users', 'national_id')->ignore($this->organization->get('id')), new ValidNationalCard()],
            'organization_name' => ['required', 'string'],
            'organization_level' => ['required', 'string'],
            'national_card' => ['nullable', 'image'],
            'personnel_card' => ['nullable', 'image'],
            'introduction_letter' => ['nullable', 'image'],
            'province' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'postal' => ['required', 'string', new ValidIranPostalCode()],
            'landline_number' => ['nullable', 'string', new ValidPhoneNumber()],
            'phone_number' => ['required', 'string', new ValidPhoneNumber()],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $validData = $this->validate();

        if ($validData['national_card']) {
            $validData['national_card'] = $this->uploadNationalImage($validData['national_card']);
        } else {
            unset($validData['national_card']);
        }

        if ($validData['personnel_card']) {
            $validData['personnel_card'] = $this->uploadPersonnelImage($validData['personnel_card']);
        } else {
            unset($validData['personnel_card']);
        }

        if ($validData['introduction_letter']) {
            $validData['introduction_letter'] = $this->uploadIntroductionImage($validData['introduction_letter']);
        } else {
            unset($validData['introduction_letter']);
        }

        $validData['status'] = 'edited';

        DB::beginTransaction();
        try {
            OrganizationUser::query()->find($this->organization->get('id'))->update($validData);
            $user = User::query()->firstOrCreate(
                [
                    'national_id' => $this->organization->get('national_id')
                ],
                [
                    'name' => $validData['fname'] . ' ' . $validData['lname'],
                    'national_id' => $validData['national_id'],
                    'phone_number' => $validData['phone_number'],
                ],
            );
            $user->roles()->sync(Role::query()->whereName(Role::ORGANIZATION_ROLE)->first()->id);
            DB::commit();

            toastr()->success('اطلاعات شما با موفقیت ارسال شد و به زودی بررسی می شود.', 'موفق');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            return toastr()->error('خطای سرور در ارسال اطلاعات.' . "<br/>" . 'دوباره تلاش کنید.' . "<br/>" . $e->getMessage(), 'ناموفق');
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

    public function render()
    {
        return view('livewire.components.organization-profile');
    }
}
