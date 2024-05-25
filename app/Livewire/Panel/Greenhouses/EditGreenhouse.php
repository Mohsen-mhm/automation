<?php

namespace App\Livewire\Panel\Greenhouses;

use App\Models\Config;
use App\Models\Greenhouse;
use App\Models\Role;
use App\Models\User;
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
use Morilog\Jalali\Jalalian;

class EditGreenhouse extends Component
{
    use WithFileUploads;

    public $greenhouse;
    public array $substrates;
    public array $productTypes;
    public array $greenhouseStatuses;
    public array $statuses;
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
    public string $old_owner_national_id = '';
    public string $owner_national_id = '';
    public bool $climate_system = false;
    public bool $feeding_system = false;
    public string $province = '';
    public string $city = '';
    public string $address = '';
    public string $postal = '';
    public string $location_link = '';
    public $operation_licence;
    public $image;
    public $status;

    protected $listeners = [
        'editInitialize' => 'initialization',
        'refresh' => '$refresh'
    ];

    public function initialization($id): void
    {
        $this->reset();
        $this->greenhouse = Greenhouse::query()->find($id);
        $this->name = collect($this->greenhouse)->get('name');
        $this->licence_number = collect($this->greenhouse)->get('licence_number');
        $this->substrate_type = collect($this->greenhouse)->get('substrate_type');
        $this->product_type = collect($this->greenhouse)->get('product_type');
        $this->meterage = collect($this->greenhouse)->get('meterage');
        $this->greenhouse_status = collect($this->greenhouse)->get('greenhouse_status');
        $this->meterage = collect($this->greenhouse)->get('meterage');
        $this->operation_date = Jalalian::fromDateTime(collect($this->greenhouse)->get('operation_date'))->toDateString();
        $this->construction_date = Jalalian::fromDateTime(collect($this->greenhouse)->get('construction_date'))->toDateString();
        $this->owner_name = collect($this->greenhouse)->get('owner_name');
        $this->owner_phone = collect($this->greenhouse)->get('owner_phone');
        $this->old_owner_national_id = collect($this->greenhouse)->get('owner_national_id');
        $this->owner_national_id = collect($this->greenhouse)->get('owner_national_id');
        $this->climate_system = collect($this->greenhouse)->get('climate_system');
        $this->feeding_system = collect($this->greenhouse)->get('feeding_system');
        $this->address = collect($this->greenhouse)->get('address');
        $this->postal = collect($this->greenhouse)->get('postal');
        $this->location_link = collect($this->greenhouse)->get('location_link');
        $this->coordinates = collect($this->greenhouse)->get('coordinates');
        $this->latitude = collect($this->greenhouse)->get('latitude');
        $this->longitude = collect($this->greenhouse)->get('longitude');
        $this->status = collect($this->greenhouse)->get('status');

    }

    public function mount()
    {
        $this->substrates = collect(json_decode(collect(Config::query()->whereName(Config::SUBSTRATE)->first())->get('value')))->toArray();
        $this->productTypes = collect(json_decode(collect(Config::query()->whereName(Config::PRODUCT_TYPE)->first())->get('value')))->toArray();
        $this->greenhouseStatuses = collect(json_decode(collect(Config::query()->whereName(Config::GREENHOUSE_STATUS)->first())->get('value')))->toArray();
        $this->statuses = Config::getStatuses()->toArray();
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'licence_number' => ['required', 'string', 'min:4', Rule::unique('greenhouses', 'licence_number')->ignore(collect($this->greenhouse)->get('id'))],
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
            'status' => ['nullable', 'string'],
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
        $validData['operation_date'] = $this->operation_date;
        $validData['construction_date'] = $this->construction_date;

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

        if ($validData['status']) {
            $validData['active'] = $validData['status'] == Config::STATUS_CONFIRMED ? 1 : 0;
        } else {
            $validData['status'] = Config::STATUS_EDITED;
            $validData['active'] = 0;
        }

        DB::beginTransaction();
        try {
            $this->greenhouse->update($validData);
            $user = User::query()->firstOrCreate(
                [
                    'national_id' => $this->old_owner_national_id
                ],
                [
                    'name' => $validData['name'],
                    'national_id' => $validData['owner_national_id'],
                    'phone_number' => $validData['owner_phone'],
                ]
            );
            $user->roles()->sync(Role::query()->whereName(Role::GREENHOUSE_ROLE)->first()->id);
            $user->update(['active' => $validData['active']]);
            DB::commit();

            $this->dispatch('refresh-table');
            $this->dispatch('close-edit-modal');
            $this->reset();
            toastr()->success('اطلاعات با موفقیت ثبت شد.', 'موفق');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            $this->revertDate();
            return toastr()->error('خطای سرور در ارسال اطلاعات.' . "<br/>" . 'دوباره تلاش کنید.' . "<br/>", 'ناموفق');
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
        $this->operation_date = $this->operation_date ? Jalalian::fromFormat('Y/m/d', $this->operation_date)->toCarbon()->toDateString() : null;
        $this->construction_date = $this->construction_date ? Jalalian::fromFormat('Y/m/d', $this->construction_date)->toCarbon()->toDateString() : null;
    }

    private function revertDate(): void
    {
        $this->operation_date = $this->operation_date ? Jalalian::fromDateTime($this->operation_date)->toDateString() : null;
        $this->construction_date = $this->construction_date ? Jalalian::fromDateTime($this->construction_date)->toDateString() : null;
    }

    public function render()
    {
        return view('livewire.panel.greenhouses.edit-greenhouse');
    }
}
