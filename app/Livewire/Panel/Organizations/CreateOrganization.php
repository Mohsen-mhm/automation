<?php

namespace App\Livewire\Panel\Organizations;

use App\Models\Config;
use App\Models\OrganizationUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Milwad\LaravelValidate\Rules\ValidIranPostalCode;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;

class CreateOrganization extends Component
{
    use WithFileUploads;

    public array $statuses;

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
    public $status;

    public function mount()
    {
        $this->statuses = Config::getStatuses()->toArray();
    }

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
            'postal' => ['required', 'string', new ValidIranPostalCode()],
            'landline_number' => ['nullable', 'string', new ValidPhoneNumber()],
            'phone_number' => ['required', 'string', new ValidPhoneNumber()],
            'status' => ['nullable', 'string', 'in:' . collect($this->statuses)->pluck('name')->implode(',')],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $validData = $this->validate();

        $validData['national_card'] = $this->uploadNationalImage($validData['national_card']);
        $validData['personnel_card'] = $this->uploadPersonnelImage($validData['personnel_card']);
        $validData['introduction_letter'] = $this->uploadIntroductionImage($validData['introduction_letter']);


        if ($validData['status']) {
            $validData['active'] = $validData['status'] == Config::STATUS_CONFIRMED ? 1 : 0;
        }

        DB::beginTransaction();
        try {
            OrganizationUser::create($validData);
            $user = User::query()->firstOrCreate(
                [
                    'national_id' => $validData['national_id']
                ],
                [
                    'name' => $validData['fname'] . ' ' . $validData['lname'],
                    'national_id' => $validData['national_id'],
                    'phone_number' => $validData['phone_number'],
                ],
            );
            $user->roles()->sync(Role::query()->whereName(Role::ORGANIZATION_ROLE)->first()->id);
            DB::commit();

            toastr()->success('اطلاعات با موفقیت ثبت شد.', 'موفق');
            $this->reset();
            $this->dispatch('close-create-modal');
            $this->dispatch('refresh-table');
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
        return view('livewire.panel.organizations.create-organization');
    }
}
