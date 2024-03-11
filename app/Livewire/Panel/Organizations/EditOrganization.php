<?php

namespace App\Livewire\Panel\Organizations;

use App\Models\Config;
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

class EditOrganization extends Component
{
    use WithFileUploads;

    public $organization;

    public array $statuses;

    public string $fname = '';
    public string $lname = '';
    public string $national_id = '';
    public string $old_national_id = '';
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
    public $status;

    protected $listeners = [
        'editInitialize' => 'initialization',
        'refresh' => '$refresh'
    ];

    public function initialization($id): void
    {
        $this->reset();
        $this->organization = OrganizationUser::query()->find($id);
        $this->fname = collect($this->organization)->get('fname');
        $this->lname = collect($this->organization)->get('lname');
        $this->old_national_id = collect($this->organization)->get('national_id');
        $this->national_id = collect($this->organization)->get('national_id');
        $this->organization_name = collect($this->organization)->get('organization_name');
        $this->organization_level = collect($this->organization)->get('organization_level');
        $this->address = collect($this->organization)->get('address');
        $this->postal = collect($this->organization)->get('postal');
        $this->landline_number = collect($this->organization)->get('landline_number');
        $this->phone_number = collect($this->organization)->get('phone_number');
        $this->status = collect($this->organization)->get('status');
    }

    public function mount()
    {
        $this->statuses = Config::getStatuses()->toArray();
    }

    public function rules()
    {
        return [
            'fname' => ['required', 'string', 'min:2', 'max:150'],
            'lname' => ['required', 'string', 'min:2', 'max:150'],
            'national_id' => ['required', 'string', new ValidNationalCard(), Rule::unique('organization_users', 'national_id')->ignore($this->organization->id)],
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
            'status' => ['nullable', 'string'],
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

        if ($validData['status']) {
            $validData['active'] = $validData['status'] == Config::STATUS_CONFIRMED ? 1 : 0;
        } else {
            $validData['status'] = Config::STATUS_EDITED;
            $validData['active'] = 0;
        }

        DB::beginTransaction();
        try {
            $this->organization->update($validData);
            $user = User::query()->firstOrCreate(
                [
                    'national_id' => $this->old_national_id
                ],
                [
                    'name' => $validData['fname'] . ' ' . $validData['lname'],
                    'national_id' => $validData['national_id'],
                    'phone_number' => $validData['phone_number'],
                ],
            );
            $user->roles()->sync(Role::query()->whereName(Role::ORGANIZATION_ROLE)->first()->id);
            $user->update(['active' => $validData['active']]);
            DB::commit();

            toastr()->success('اطلاعات با موفقیت ثبت شد.', 'موفق');
            $this->reset();
            $this->dispatch('close-edit-modal');
            $this->dispatch('refresh-table');
            return redirect()->back();
        } catch (\Exception $e) {
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

    public function render()
    {
        return view('livewire.panel.organizations.edit-organization');
    }
}
