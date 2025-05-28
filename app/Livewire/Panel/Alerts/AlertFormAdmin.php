<?php

namespace App\Livewire\Panel\Alerts;

use App\Models\Greenhouse;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AlertFormAdmin extends Component
{
    public array $validData;

    public $alert;

    public int $greenhouse_id;
    public bool $lux_active = false;
    public int|null $min_lux = null;
    public int|null $max_lux = null;
    public bool $temp_active = false;
    public int|null $min_temp = null;
    public int|null $max_temp = null;
    public bool $wind_active = false;
    public int|null $min_wind = null;
    public int|null $max_wind = null;
    public bool $humidity_active = false;
    public int|null $min_humidity = null;
    public int|null $max_humidity = null;

    public function mount($id): void
    {

        $this->alert = Greenhouse::query()->find($id)->alert;

        $this->lux_active = collect($this->alert)->get('lux_active');
        $this->min_lux = collect($this->alert)->get('min_lux');
        $this->max_lux = collect($this->alert)->get('max_lux');

        $this->temp_active = collect($this->alert)->get('temp_active');
        $this->min_temp = collect($this->alert)->get('min_temp');
        $this->max_temp = collect($this->alert)->get('max_temp');

        $this->wind_active = collect($this->alert)->get('wind_active');
        $this->min_wind = collect($this->alert)->get('min_wind');
        $this->max_wind = collect($this->alert)->get('max_wind');

        $this->humidity_active = collect($this->alert)->get('humidity_active');
        $this->min_humidity = collect($this->alert)->get('min_humidity');
        $this->max_humidity = collect($this->alert)->get('max_humidity');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function rules(): array
    {
        return [
            'greenhouse_id' => ['required', 'exists:greenhouses,id'],

            'lux_active' => ['boolean'],
            'min_lux' => ['nullable', 'integer'],
            'max_lux' => ['nullable', 'integer'],

            'temp_active' => ['boolean'],
            'min_temp' => ['nullable', 'integer'],
            'max_temp' => ['nullable', 'integer'],

            'wind_active' => ['boolean'],
            'min_wind' => ['nullable', 'integer'],
            'max_wind' => ['nullable', 'integer'],

            'humidity_active' => ['boolean'],
            'min_humidity' => ['nullable', 'integer'],
            'max_humidity' => ['nullable', 'integer'],
        ];
    }

    public function store()
    {
        if (auth()->user()->hasRole(Role::ADMIN_ROLE)) {
            try {
                if ($this->setLux() && $this->setTemp() && $this->setWind() && $this->setHumidity()) {
                    DB::beginTransaction();
                    $this->alert->update($this->validData);
                    DB::commit();
                    toastr()->success('اطلاعات با موفقیت ثبت شد', 'موفق');
                }
            } catch (\Exception) {
                DB::rollBack();
                return toastr()->error('خطا در برقراری ارتباط با سرور' . '<br/>' . 'دوباره تلاش کنید', 'خطا');
            }
        }
    }

    private function setLux(): bool
    {
        if ($this->lux_active) {
            if (is_null($this->min_lux) || is_null($this->max_lux)) {
                $this->addError('lux_error', 'در صورت انتخاب روشنایی محیط، مقادیر بالا الزامی است.');
                return false;
            } else {
                $this->validData['lux_active'] = $this->lux_active;
                $this->validData['min_lux'] = $this->min_lux;
                $this->validData['max_lux'] = $this->max_lux;
                return true;
            }
        } else {
            $this->validData['lux_active'] = false;
            $this->validData['min_lux'] = null;
            $this->validData['max_lux'] = null;
            return true;
        }
    }

    private function setTemp(): bool
    {
        if ($this->temp_active) {
            if (is_null($this->min_temp) || is_null($this->max_temp)) {
                $this->addError('temp_error', 'در صورت انتخاب دمای محیط، مقادیر بالا الزامی است.');
                return false;
            } else {
                $this->validData['temp_active'] = $this->temp_active;
                $this->validData['min_temp'] = $this->min_temp;
                $this->validData['max_temp'] = $this->max_temp;
                return true;
            }
        } else {
            $this->validData['temp_active'] = false;
            $this->validData['min_temp'] = null;
            $this->validData['max_temp'] = null;
            return true;
        }
    }

    private function setWind(): bool
    {
        if ($this->wind_active) {
            if (is_null($this->min_wind) || is_null($this->max_wind)) {
                $this->addError('wind_error', 'در صورت انتخاب سرعت باد محیط، مقادیر بالا الزامی است.');
                return false;
            } else {
                $this->validData['wind_active'] = $this->wind_active;
                $this->validData['min_wind'] = $this->min_wind;
                $this->validData['max_wind'] = $this->max_wind;
                return true;
            }
        } else {
            $this->validData['wind_active'] = false;
            $this->validData['min_wind'] = null;
            $this->validData['max_wind'] = null;
            return true;
        }
    }

    private function setHumidity(): bool
    {
        if ($this->humidity_active) {
            if (is_null($this->min_humidity) || is_null($this->max_humidity)) {
                $this->addError('humidity_error', 'در صورت انتخاب رطوبت محیط، مقادیر بالا الزامی است.');
                return false;
            } else {
                $this->validData['humidity_active'] = $this->humidity_active;
                $this->validData['min_humidity'] = $this->min_humidity;
                $this->validData['max_humidity'] = $this->max_humidity;
                return true;
            }
        } else {
            $this->validData['humidity_active'] = false;
            $this->validData['min_humidity'] = null;
            $this->validData['max_humidity'] = null;
            return true;
        }
    }

    public function render()
    {
        return view('livewire.panel.alerts.alert-form');
    }
}
