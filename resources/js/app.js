import './bootstrap';
import 'flowbite';
import './livewire-datepicker-datepicker';

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('pageLoader').classList.remove('hidden');

    setTimeout(function () {
        document.getElementById('pageLoader').classList.add('hidden');
    }, 1500);
});

Livewire.on('close-edit-modal', () => {
    document.querySelector('#close-edit-modal').click();
});

Livewire.on('close-create-modal', () => {
    document.querySelector('#close-create-modal').click();
});

Livewire.on('close-delete-modal', () => {
    document.querySelector('#close-delete-modal').click();
});

Livewire.on('close-deactivate-modal', () => {
    document.querySelector('#close-deactivate-modal').click();
});

Livewire.on('close-assign-modal', () => {
    document.querySelector('#close-assign-modal').click();
});

Livewire.on('close-show-modal', () => {
    document.querySelector('#close-show-modal').click();
});
