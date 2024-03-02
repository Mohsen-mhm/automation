<?php

namespace App\Livewire\Panel\Auth\Company;

use App\Models\Company;
use App\Models\Config;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Milwad\LaravelValidate\Rules\ValidIranPostalCode;
use Milwad\LaravelValidate\Rules\ValidJalaliDate;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;
use Milwad\LaravelValidate\Rules\ValidUrl;
use Morilog\Jalali\Jalalian;

class Register extends Component
{
    use WithFileUploads;

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
    public $company_logo;
    public string $brand = '';
    public $brand_logo;
    public $trademark_certificate;
    public string $province = '';
    public string $city = '';
    public string $address = '';
    public string $postal = '';
    public string $landline_number = '';
    public string $phone_number = '';
    public string $location_link = '';
    public string $website = '';
    public string $email = '';
    public $official_newspaper = '';
    public $operation_licence;

    public function mount()
    {
        $this->companyTypes = json_decode(collect(Config::query()->whereName(Config::COMPANY_TYPE)->first())->get('value'), false, 512, JSON_THROW_ON_ERROR);
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'type' => ['required', 'string', 'in:' . collect($this->companyTypes)->implode(',')],
            'national_id' => ['required', 'string', 'min:4', 'unique:companies,national_id'],
            'registration_number' => ['required', 'string', 'unique:companies,registration_number'],
            'registration_place' => ['required', 'string'],
            'registration_date' => ['required', 'string'],
            'climate_system' => ['required', 'boolean'],
            'feeding_system' => ['required', 'boolean'],
            'ceo_name' => ['required', 'string'],
            'ceo_phone' => ['required', 'string', new ValidPhoneNumber()],
            'ceo_national_id' => ['required', 'string', new ValidNationalCard()],
            'interface_name' => ['required', 'string'],
            'interface_phone' => ['required', 'string', new ValidPhoneNumber()],
            'company_logo' => ['required', 'image'],
            'brand' => ['required', 'string'],
            'brand_logo' => ['required', 'image'],
            'trademark_certificate' => ['required', 'image'],
            'province' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'postal' => ['required', 'string', new ValidIranPostalCode()],
            'landline_number' => ['required', 'string', new ValidPhoneNumber()],
            'phone_number' => ['nullable', 'string', new ValidPhoneNumber()],
            'location_link' => ['required', 'string', new ValidUrl()],
            'website' => ['required', 'string', new ValidUrl()],
            'email' => ['required', 'email'],
            'official_newspaper' => ['required', 'file', 'mimes:jpeg,png,svg,pdf'],
            'operation_licence' => ['required', 'image'],
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
            } catch (Exception) {
                toastr()->error('دریافت مشخصات ناموفق بود.' . '<br/>' . 'لینک را مجددا وارد نمایید.', 'ناموفق');
            }
        }
    }

    public function register()
    {
        $validData = $this->validate();
        $this->assignDate();
        $validData['coordinates'] = $this->coordinates;
        $validData['latitude'] = $this->latitude;
        $validData['longitude'] = $this->longitude;

        $validData['company_logo'] = $this->uploadCompanyLogo($validData['company_logo']);
        $validData['brand_logo'] = $this->uploadBrandLogo($validData['brand_logo']);
        $validData['trademark_certificate'] = $this->uploadTrademarkCertificate($validData['trademark_certificate']);
        $validData['operation_licence'] = $this->uploadOperationImage($validData['operation_licence']);
        $validData['official_newspaper'] = $this->uploadNewspaperFile($validData['official_newspaper']);

        DB::beginTransaction();
        try {
            Company::create($validData);
            $user = User::query()->firstOrCreate(
                [
                    'national_id' => $validData['national_id']
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
            return redirect()->route('home');
        } catch (Exception $e) {
            DB::rollback();
            $this->revertDate();
            return toastr()->error('خطای سرور در ارسال اطلاعات.' . "<br/>" . 'دوباره تلاش کنید.' . "<br/>" . $e->getMessage(), 'ناموفق');
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
        } catch (Exception $e) {
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
        $this->registration_date = $this->registration_date ? Jalalian::fromFormat('Y/m/d', $this->registration_date)->toCarbon()->toDateString() : null;
    }

    private function revertDate(): void
    {
        $this->registration_date = $this->registration_date ? Jalalian::fromDateTime($this->registration_date)->toDateString() : null;
    }

    #[Layout('livewire.panel.auth.layouts.app')]
    public function render()
    {
        return view('livewire.panel.auth.company.register');
    }
}
