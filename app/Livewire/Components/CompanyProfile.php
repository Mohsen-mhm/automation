<?php

namespace App\Livewire\Components;

use App\Models\Company;
use App\Models\Config;
use App\Models\Greenhouse;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Milwad\LaravelValidate\Rules\ValidIranPostalCode;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;
use Milwad\LaravelValidate\Rules\ValidUrl;

class CompanyProfile extends Component
{
    use WithFileUploads;

    public $company = [];
    public array $companyTypes;

    public string $coordinates = '-';
    public string $latitude = '-';
    public string $longitude = '-';

    public string $name = '';
    public string $type = '';
    public string $national_id = '';
    public string $registration_number = '';
    public string $registration_place = '';
    public string $registration_date = '';
    public bool $climate_system = false;
    public bool $feeding_system = false;
    public string $ceo_name = '';
    public string $ceo_phone = '';
    public string $ceo_national_id = '';
    public string $interface_name = '';
    public string $interface_phone = '';
    public string $brand = '';
    public $company_logo;
    public $brand_logo;
    public $trademark_certificate;
    public $official_newspaper;
    public $operation_licence;

    public $old_company_logo;
    public $old_brand_logo;
    public $old_trademark_certificate;
    public $old_official_newspaper;
    public $old_operation_licence;
    public string $province = '';
    public string $city = '';
    public string $address = '';
    public string $postal = '';
    public string $landline_number = '';
    public string $phone_number = '';
    public string $location_link = '';
    public string $website = '';
    public string $email = '';

    public function mount(): void
    {
        $this->company = collect(Company::query()->where([
            'national_id' => auth()->user()->getNationalId(),
            'interface_phone' => auth()->user()->getPhone()
        ])->first());

        $this->companyTypes = json_decode(collect(Config::query()->whereName(Config::COMPANY_TYPE)->first())->get('value'), false, 512, JSON_THROW_ON_ERROR);

        $this->name = $this->company->get('name');
        $this->type = $this->company->get('type');
        $this->national_id = $this->company->get('national_id');
        $this->registration_number = $this->company->get('registration_number');
        $this->registration_place = $this->company->get('registration_place');
        $this->registration_date = $this->company->get('registration_date');
        $this->climate_system = $this->company->get('climate_system');
        $this->feeding_system = $this->company->get('feeding_system');
        $this->ceo_name = $this->company->get('ceo_name');
        $this->ceo_phone = $this->company->get('ceo_phone');
        $this->ceo_national_id = $this->company->get('ceo_national_id');
        $this->interface_name = $this->company->get('interface_name');
        $this->interface_phone = $this->company->get('interface_phone');
        $this->brand = $this->company->get('brand');
        $this->province = $this->company->get('province');
        $this->city = $this->company->get('city');
        $this->address = $this->company->get('address');
        $this->postal = $this->company->get('postal');
        $this->landline_number = $this->company->get('landline_number');
        $this->phone_number = $this->company->get('phone_number');
        $this->location_link = $this->company->get('location_link');
        $this->coordinates = $this->company->get('coordinates');
        $this->latitude = $this->company->get('latitude');
        $this->longitude = $this->company->get('longitude');
        $this->website = $this->company->get('website');
        $this->email = $this->company->get('email');
        $this->old_company_logo = $this->company->get('company_logo');
        $this->old_brand_logo = $this->company->get('brand_logo');
        $this->old_trademark_certificate = $this->company->get('trademark_certificate');
        $this->old_official_newspaper = $this->company->get('official_newspaper');
        $this->old_operation_licence = $this->company->get('operation_licence');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'type' => ['required', 'string', 'in:' . collect($this->companyTypes)->implode(',')],
            'national_id' => ['required', 'string', 'min:4', Rule::unique('companies', 'national_id')->ignore($this->company->get('id'))],
            'registration_number' => ['required', 'string', Rule::unique('companies', 'registration_number')->ignore($this->company->get('id'))],
            'registration_place' => ['required', 'string'],
            'registration_date' => ['required', 'string'],
            'climate_system' => ['required', 'boolean'],
            'feeding_system' => ['required', 'boolean'],
            'ceo_name' => ['required', 'string'],
            'ceo_phone' => ['required', 'string', new ValidPhoneNumber()],
            'ceo_national_id' => ['required', 'string', new ValidNationalCard()],
            'interface_name' => ['required', 'string'],
            'interface_phone' => ['required', 'string', new ValidPhoneNumber()],
            'company_logo' => ['nullable', 'image'],
            'brand' => ['required', 'string'],
            'brand_logo' => ['nullable', 'image'],
            'trademark_certificate' => ['nullable', 'image'],
            'province' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'postal' => ['required', 'string', new ValidIranPostalCode()],
            'landline_number' => ['required', 'string', new ValidPhoneNumber()],
            'phone_number' => ['nullable', 'string', new ValidPhoneNumber()],
            'location_link' => ['required', 'string', new ValidUrl()],
            'website' => ['required', 'string', new ValidUrl()],
            'email' => ['required', 'email'],
            'official_newspaper' => ['nullable', 'file', 'mimes:jpeg,png,svg,pdf'],
            'operation_licence' => ['nullable', 'image'],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($this->location_link) {
            try {
                $coordinates = $this->getCoordinates($this->location_link);
                if (is_array($coordinates)) {
                    $this->coordinates = $coordinates['coordinates'];
                    $this->latitude = $coordinates['latitude'];
                    $this->longitude = $coordinates['longitude'];
                } else {
                    toastr()->error('دریافت مشخصات ناموفق بود.' . '<br/>' . 'لینک را مجددا وارد نمایید.', 'ناموفق');
                }
            } catch (\Exception) {
                toastr()->error('دریافت مشخصات ناموفق بود.' . '<br/>' . 'لینک را مجددا وارد نمایید.', 'ناموفق');
            }
        }
    }

    public function update()
    {
        $this->assignDate();
        $validData = $this->validate();
        $validData['coordinates'] = $this->coordinates;
        $validData['latitude'] = $this->latitude;
        $validData['longitude'] = $this->longitude;

        if ($validData['company_logo']) {
            $validData['company_logo'] = $this->uploadCompanyLogo($validData['company_logo']);
        } else {
            unset($validData['company_logo']);
        }

        if ($validData['brand_logo']) {
            $validData['brand_logo'] = $this->uploadBrandLogo($validData['brand_logo']);
        } else {
            unset($validData['brand_logo']);
        }

        if ($validData['trademark_certificate']) {
            $validData['trademark_certificate'] = $this->uploadTrademarkCertificate($validData['trademark_certificate']);
        } else {
            unset($validData['trademark_certificate']);
        }

        if ($validData['operation_licence']) {
            $validData['operation_licence'] = $this->uploadOperationImage($validData['operation_licence']);
        } else {
            unset($validData['operation_licence']);
        }

        if ($validData['official_newspaper']) {
            $validData['official_newspaper'] = $this->uploadNewspaperFile($validData['official_newspaper']);
        } else {
            unset($validData['official_newspaper']);
        }

        $validData['status'] = 'edited';

        DB::beginTransaction();
        try {
            Company::query()->find($this->company->get('id'))->update($validData);
            $user = User::query()->firstOrCreate(
                [
                    'national_id' => $this->company->get('national_id')
                ],
                [
                    'name' => $validData['name'],
                    'national_id' => $validData['national_id'],
                    'phone_number' => $validData['interface_phone'],
                ]
            );
            $user->roles()->sync(Role::query()->whereName(Role::COMPANY_ROLE)->first()->id);

            DB::commit();

            toastr()->success('اطلاعات شما با موفقیت ارسال شد و به زودی بررسی می شود.', 'موفق');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            return toastr()->error('خطای سرور در ارسال اطلاعات.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
        }
    }

    private function uploadCompanyLogo($companyLogo)
    {
        $imageName = Str::random(20);
        try {
            $path = 'storage/logos/' . now()->year . '/' . now()->month . '/' . now()->day;
            $companyLogo->storeAs($path, $imageName . '.' . $companyLogo->extension());
            $companyLogoName = $path . '/' . $imageName . '.' . $companyLogo->extension();
        } catch (\Exception) {
            $companyLogoName = null;
        }

        return $companyLogoName ?: toastr()->error('خطای سرور در اپلود پروانه بهره برداری.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
    }

    private function uploadBrandLogo($brandLogo)
    {
        $imageName = Str::random(20);
        try {
            $path = 'storage/logos/' . now()->year . '/' . now()->month . '/' . now()->day;
            $brandLogo->storeAs($path, $imageName . '.' . $brandLogo->extension());
            $brandLogoName = $path . '/' . $imageName . '.' . $brandLogo->extension();
        } catch (\Exception) {
            $brandLogoName = null;
        }

        return $brandLogoName ?: toastr()->error('خطای سرور در اپلود پروانه بهره برداری.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
    }

    private function uploadTrademarkCertificate($trademarkCertificate)
    {
        $imageName = Str::random(20);
        try {
            $path = 'storage/certificates/' . now()->year . '/' . now()->month . '/' . now()->day;
            $trademarkCertificate->storeAs($path, $imageName . '.' . $trademarkCertificate->extension());
            $trademarkCertificateName = $path . '/' . $imageName . '.' . $trademarkCertificate->extension();
        } catch (\Exception) {
            $trademarkCertificateName = null;
        }

        return $trademarkCertificateName ?: toastr()->error('خطای سرور در اپلود پروانه بهره برداری.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
    }

    private function uploadOperationImage($operation_licence)
    {
        $imageName = Str::random(20);
        try {
            $path = 'storage/licences/' . now()->year . '/' . now()->month . '/' . now()->day;
            $operation_licence->storeAs($path, $imageName . '.' . $operation_licence->extension());
            $operationImageName = $path . '/' . $imageName . '.' . $operation_licence->extension();
        } catch (\Exception) {
            $operationImageName = null;
        }

        return $operationImageName ?: toastr()->error('خطای سرور در اپلود پروانه بهره برداری.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
    }

    private function uploadNewspaperFile($newspaper)
    {
        $imageName = Str::random(20);
        try {
            $path = 'storage/newspaper/' . now()->year . '/' . now()->month . '/' . now()->day;
            $newspaper->storeAs($path, $imageName . '.' . $newspaper->extension());
            $NewspaperFileName = $path . '/' . $imageName . '.' . $newspaper->extension();
        } catch (\Exception) {
            $NewspaperFileName = null;
        }

        return $NewspaperFileName ?: toastr()->error('خطای سرور در اپلود پروانه بهره برداری.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
    }

    public function getCoordinates(string $url)
    {
        try {
            $response = Http::get($url);

            $urlHandlerStats = $response->handlerStats()['url'];

            return $this->extractCoordinatesFromUrl($urlHandlerStats);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function extractCoordinatesFromUrl(string $url)
    {
        $urlParts = parse_url($url);

        if (!isset($urlParts['path'])) {
            return ['error' => 'Unable to extract coordinates from the final URL'];
        }

        $path = $urlParts['path'];

        if (strpos($path, '@')) {
            preg_match("/@(-?\d+\.\d+),(-?\d+\.\d+)/", $path, $matches);

            return [
                'coordinates' => $matches[1] . ',' . $matches[2],
                'latitude' => $matches[1],
                'longitude' => $matches[2],
            ];
        } else {
            $pathParts = explode('/', $path);
            $lastPart = end($pathParts);

            [$latitude, $longitude] = explode(',', $lastPart);

            return [
                'coordinates' => $lastPart,
                'latitude' => $latitude,
                'longitude' => $longitude,
            ];
        }
    }

    private function assignDate(): void
    {
        $this->registration_date = $this->registration_date ? Carbon::createFromTimestamp($this->registration_date)->toDateTimeString() : null;
    }

    public function render()
    {
        return view('livewire.components.company-profile');
    }
}
