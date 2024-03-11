<?php

namespace App\Livewire\Panel\Auth\Greenhouse;

use App\Models\Config;
use App\Models\Greenhouse;
use App\Models\GreenhouseAlert;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Milwad\LaravelValidate\Rules\ValidIranPostalCode;
use Milwad\LaravelValidate\Rules\ValidJalaliDate;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;
use Milwad\LaravelValidate\Rules\ValidUrl;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class Register extends Component
{
    use WithFileUploads;

    public array $substrates;
    public array $productTypes;
    public array $greenhouseStatuses;
    public $coordinates = '-';
    public $latitude = '-';
    public $longitude = '-';

    public string $name = '';
    public string $licence_number = '';
    public string $substrate_type = '';
    public string $product_type = '';
    public string $meterage = '';
    public string $greenhouse_status = '';
    public string $construction_date = '';
    public string $operation_date = '';
    public string $owner_name = '';
    public string $owner_phone = '';
    public string $owner_national_id = '';
    public bool $climate_system = false;
    public bool $feeding_system = false;
    public string $province = '';
    public string $city = '';
    public string $address = '';
    public string $postal = '';
    public string $location_link = '';
    public $operation_licence = '';
    public $image = '';

    public function mount()
    {
        try {
            $this->substrates = json_decode(collect(Config::query()->whereName(Config::SUBSTRATE)->first())->get('value'));
            $this->productTypes = json_decode(collect(Config::query()->whereName(Config::PRODUCT_TYPE)->first())->get('value'));
            $this->greenhouseStatuses = json_decode(collect(Config::query()->whereName(Config::GREENHOUSE_STATUS)->first())->get('value'));
        } catch (Exception) {
            toastr()->error('خطای سرور، دوباره تلاش کنید', 'ناموفق');
            return redirect()->route('login.greenhouse');
        }
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'licence_number' => ['required', 'string', 'min:4', 'unique:greenhouses,licence_number'],
            'substrate_type' => ['required', 'string'],
            'product_type' => ['required', 'string'],
            'meterage' => ['required', 'string'],
            'greenhouse_status' => ['required', 'string'],
            'operation_date' => ['nullable', 'string'],
            'construction_date' => ['nullable', 'string'],
            'owner_name' => ['required', 'string', 'min:2'],
            'owner_phone' => ['required', 'string', new ValidPhoneNumber()],
            'owner_national_id' => ['required', 'string', new ValidNationalCard()],
            'climate_system' => ['required', 'boolean'],
            'feeding_system' => ['required', 'boolean'],
            'province' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'postal' => ['required', 'string', new ValidIranPostalCode()],
            'location_link' => ['required', 'string', new ValidUrl()],
            'operation_licence' => ['required', 'image'],
            'image' => ['required', 'image'],
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

        $validData['operation_licence'] = $this->uploadOperationImage($validData['operation_licence']);
        $validData['image'] = $this->uploadLogoImage($validData['image']);

        DB::beginTransaction();
        try {
            $greenhouse = Greenhouse::create($validData);
            GreenhouseAlert::create(['greenhouse_id' => $greenhouse->id]);
            $user = User::query()->firstOrCreate(
                [
                    'national_id' => $validData['owner_national_id']
                ],
                [
                    'name' => $validData['name'],
                    'national_id' => $validData['owner_national_id'],
                    'phone_number' => $validData['owner_phone'],
                ]
            );
            $user->roles()->sync(Role::query()->whereName(Role::GREENHOUSE_ROLE)->first()->id);

            DB::commit();

            toastr()->success('اطلاعات شما با موفقیت ارسال شد و به زودی بررسی می شود.', 'موفق');
            return redirect()->route('home');
        } catch (Exception $e) {
            DB::rollback();
            $this->revertDate();
            return toastr()->error('خطای سرور در ارسال اطلاعات.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
        }
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

    private function uploadLogoImage($logo)
    {
        $imageName = Str::random(20);
        try {
            $path = 'storage/logos/' . now()->year . '/' . now()->month . '/' . now()->day;
            $logo->storeAs($path, $imageName . '.' . $logo->extension());
            $logoImageName = $path . '/' . $imageName . '.' . $logo->extension();
        } catch (\Exception) {
            $logoImageName = null;
        }

        return $logoImageName ?: toastr()->error('خطای سرور در اپلود لوگو.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
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
        $this->operation_date = $this->operation_date ? Jalalian::fromFormat('Y/m/d', $this->operation_date)->toCarbon()->toDateString() : null;
        $this->construction_date = $this->construction_date ? Jalalian::fromFormat('Y/m/d', $this->construction_date)->toCarbon()->toDateString() : null;
    }

    private function revertDate(): void
    {
        $this->operation_date = $this->operation_date ? Jalalian::fromDateTime($this->operation_date)->toDateString() : null;
        $this->construction_date = $this->construction_date ? Jalalian::fromDateTime($this->construction_date)->toDateString() : null;
    }

    #[Layout('livewire.panel.auth.layouts.app')]
    public function render()
    {
        return view('livewire.panel.auth.greenhouse.register');
    }
}
