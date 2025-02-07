<div class="w-full p-5 overflow-x-hidden">
    <div>
        <livewire:panel.contact-us.contact-us-table/>
    </div>

    @can(\App\Models\ContactUs::CONTACT_US_INDEX)
        <livewire:panel.contact-us.show-contact-us/>
    @endcan
</div>
