<div class="w-full p-5 overflow-x-hidden">
    <div>
        <form class="p-4 md:p-5" wire:submit="assign">
            @csrf

            @foreach ($permissions as $permission)
                <div class="flex items-center mb-5 pb-5 border-b border-gray-200">
                    <input type="checkbox"
                           wire:model.live="rolePermissions"
                           value="{{ $permission->id }}"
                           id="checkbox{{ $permission->id }}"
                           {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                           class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                    <label for="checkbox{{ $permission->id }}"
                           class="ms-2 text-sm font-medium text-gray-900">{{ $permission->title }}
                    </label>
                </div>
            @endforeach
            <div class="w-full flex justify-center items-center mt-2">
                @if($permissions)
                    {{ $permissions->links() }}
                @endif
            </div>
        </form>
    </div>
</div>
