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

                <!-- User Account Type -->
                <div class="form-group">
                    <label for="account_type">Account Type</label>
                    <span class="form-control">
                        @foreach (Auth::user()->account_types as $account_type)
                            @if ($loop->last)
                                {{ $account_type->account_type }}
                                @break
                            @endif
                            {{ $account_type->account_type }}, 
                        @endforeach
                    </span>
                    <x-maz-input-error for="account_types" />
                </div>
                
                <!-- Account Types -->
                <div class="form-group">
                    <label for="account_type">Choose to update account type/s</label>
                    <select id="account_type" class="form-select {{ $errors->has('account_type') ? 'is-invalid' : '' }}" size="5" wire:model.defer="state.account_type" autocomplete="account_type" multiple>
                        <livewire:account-type-livewire />
                    </select>
                    <p>Hold down the Ctrl (windows) or Command (Mac) button to select multiple options.</p>
                    <x-maz-input-error for="account_types" />
                </div>


                <button class="btn btn-primary float-end mt-2"  wire:loading.attr="disabled" wire:target="photo">Save</button>
            </form>
        </div>
    </div>
</section>
