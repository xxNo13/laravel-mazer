<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('Profile Information') }}</h4>
            <p class="card-description">{{ __('Update your account\'s profile information and email address.') }}</p>
        </div>
        <div class="card-body">
            
            <x-maz-alert class="mr-3" on="saved" color='success'>
                Saved
            </x-maz-alert>
            <form wire:submit.prevent="updateProfileInformation">
                <!-- Name -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" wire:model.defer="state.name" autocomplete="name" >
                    <x-maz-input-error for="name" />
                </div>

                <!-- Email -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <input type="email" name="email " id="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" wire:model.defer="state.email" >
                    <x-maz-input-error for="email" />
                </div>

                <!-- Office -->
                <div class="form-group">
                    <label for="office_id">Office</label>
                    <select id="office_id" class="form-control {{ $errors->has('office_id') ? 'is-invalid' : '' }}" wire:model.defer="state.office_id" autocomplete="office_id" >
                        <livewire:office-livewire />
                    </select>
                    <x-maz-input-error for="account_types" />
                </div>
                
                <!-- Account Types -->
                <div class="form-group">
                    <label for="account_types">Account Types</label>
                    <input id="account_types" type="text" class="form-control {{ $errors->has('account_types') ? 'is-invalid' : '' }}" wire:model.defer="state.account_types" autocomplete="account_types" title="Eg. Staff, Head of Delivery Unit, Head of Office, etc.">
                    <p class="text-muted">Eg. Staff, Head of Delivery Unit, Head of Office, etc.</p>
                    <x-maz-input-error for="account_types" />
                </div>

                <button class="btn btn-primary float-end mt-2"  wire:loading.attr="disabled" wire:target="photo">Save</button>
            </form>
        </div>
    </div>
</section>
