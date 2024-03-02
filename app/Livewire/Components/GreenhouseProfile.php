<?php

namespace App\Livewire\Components;

use App\Models\Config;
use App\Models\Greenhouse;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
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

class GreenhouseProfile extends Component
{
    use WithFileUploads;

    public $greenhouse;

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
    public string $operation_date = '';
    public string $construction_date = '';
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
    public $old_operation_licence = '';
    public $old_image = '';

    public function mount()
    {
        $this->greenhouse = collect(Greenhouse::query()->where([
            'owner_national_id' => auth()->user()->getNationalId(),
            'owner_phone' => auth()->user()->getPhone()
        ])->first());

        $this->substrates = json_decode(collect(Config::query()->whereName(Config::SUBSTRATE)->first())->get('value'));
        $this->productTypes = json_decode(collect(Config::query()->whereName(Config::PRODUCT_TYPE)->first())->get('value'));
        $this->greenhouseStatuses = json_decode(collect(Config::query()->whereName(Config::GREENHOUSE_STATUS)->first())->get('value'));
        $this->name = $this->greenhouse->get('name');
        $this->licence_number = $this->greenhouse->get('licence_number');
        $this->substrate_type = $this->greenhouse->get('substrate_type');
        $this->product_type = $this->greenhouse->get('product_type');
        $this->meterage = $this->greenhouse->get('meterage');
        $this->greenhouse_status = $this->greenhouse->get('greenhouse_status');
        $this->operation_date = $this->greenhouse->get('operation_date');
        $this->construction_date = $this->greenhouse->get('construction_date');
        $this->owner_name = $this->greenhouse->get('owner_name');
        $this->owner_phone = $this->greenhouse->get('owner_phone');
        $this->owner_national_id = $this->greenhouse->get('owner_national_id');
        $this->climate_system = $this->greenhouse->get('climate_system');
        $this->feeding_system = $this->greenhouse->get('feeding_system');
        $this->province = $this->greenhouse->get('province');
        $this->city = $this->greenhouse->get('city');
        $this->address = $this->greenhouse->get('address');
        $this->postal = $this->greenhouse->get('postal');
        $this->location_link = $this->greenhouse->get('location_link');
        $this->old_operation_licence = $this->greenhouse->get('operation_licence');
        $this->old_image = $this->greenhouse->get('image');
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'licence_number' => ['required', 'string', 'min:4', Rule::unique('greenhouses', 'licence_number')->ignore($this->greenhouse->get('id'))],
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
            'operation_licence' => ['nullable', 'image'],
            'image' => ['nullable', 'image'],
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

        if ($validData['operation_licence']) {
            $validData['operation_licence'] = $this->uploadOperationImage($validData['operation_licence']);
        } else {
            unset($validData['operation_licence']);
        }

        if ($validData['image']) {
            $validData['image'] = $this->uploadLogoImage($validData['image']);
        } else {
            unset($validData['image']);
        }

        DB::beginTransaction();
        try {
            Greenhouse::query()->find($this->greenhouse->get('id'))->update($validData);
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
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            return toastr()->error('خطای سرور در ارسال اطلاعات.' . "<br/>" . 'دوباره تلاش کنید.' . "<br/>" . $e->getMessage(), 'ناموفق');
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
        $this->operation_date = $this->operation_date ? Carbon::createFromTimestamp($this->operation_date)->toDateTimeString() : null;
        $this->construction_date = $this->construction_date ? Carbon::createFromTimestamp($this->construction_date)->toDateTimeString() : null;
    }

    public function render()
    {
        return view('livewire.components.greenhouse-profile');
    }
}
