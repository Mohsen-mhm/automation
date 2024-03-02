<?php

namespace App\Livewire\Panel\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Milwad\LaravelValidate\Rules\ValidNationalCard;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;

class EditUser extends Component
{
    public $user;

    #[Validate]
    public string $name;
    #[Validate]
    public string $national_id;
    #[Validate]
    public string $phone_number;

    protected $listeners = [
        'editInitialize' => 'initialization',
        'refresh' => '$refresh'
    ];

    public function initialization($id): void
    {
        $this->reset();
        $this->user = User::query()->find($id);

        $this->name = User::query()->find($id)->name;
        $this->national_id = User::query()->find($id)->national_id;
        $this->phone_number = User::query()->find($id)->phone_number;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2'],
            'national_id' => ['required', 'string', new ValidNationalCard()],
            'phone_number' => ['required', 'string', new ValidPhoneNumber()],
        ];
    }

    public function update()
    {
        $validatedData = $this->validate();

        DB::beginTransaction();
        try {
            $this->user->update($validatedData);
            DB::commit();
            $this->dispatch('refresh-table');
            $this->dispatch('close-edit-modal');
        }catch (\Exception $e){
            DB::rollBack();
        }
    }

    public function render()
    {
        return view('livewire.panel.users.edit-user');
    }
}
