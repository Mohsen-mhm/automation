<?php

namespace App\Livewire\Panel\AboutUs;

use App\Models\AboutUs;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $aboutUs;
    public $title;
    public $description;
    public $image;

    public function mount()
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(AboutUs::ABOUT_US_INDEX), 403);

        $about = AboutUs::query()->first();
        abort_if(!$about, 403);

        $this->aboutUs = $about;
        $this->title = $about->title;
        $this->description = $about->description;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:20000'],
            'image' => ['nullable', 'image', 'max:5120'],
        ];
    }

    public function update()
    {
        $validatedData = $this->validate();
        if ($validatedData['image']) {
            $image = $this->uploadAboutUsImage();
            $validatedData['image'] = $image;
        } else {
            unset($validatedData['image']);
        }

        $this->aboutUs->update($validatedData);
        toastr()->success('محتوا با موفقیت به روز رسانی شد', 'موفق');
    }

    private function uploadAboutUsImage()
    {
        $imageName = Str::random(20);
        try {
            $path = 'storage/about/' . now()->year . '/' . now()->month . '/' . now()->day;
            $this->image->storeAs($path, $imageName . '.' . $this->image->extension());
            $operationImageName = $path . '/' . $imageName . '.' . $this->image->extension();
        } catch (\Exception) {
            $operationImageName = null;
        }

        return $operationImageName ?: toastr()->error('خطای سرور در اپلود پروانه بهره برداری.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
    }

    #[Layout('livewire.panel.layouts.app')]
    public function render()
    {
        return view('livewire.panel.about-us.index');
    }
}
