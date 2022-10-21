<x-app-layout>
    <div id="auth-left">
        <h1 class="auth-title">Sign Up</h1>
        <p class="auth-subtitle mb-5">Input your data to register to our website.</p>
        <form action="" method="POST">
            @csrf
            <div class="form-group position-relative has-icon-left mb-4">
                <input type="text" class="form-control form-control-xl" name="name" placeholder="Fullname" value="{{ old('name') }}">
                <div class="form-control-icon">
                    <i class="bi bi-person"></i>
                </div>
                @error('name') <p style="color: rgb(220 38 38);">{{ $message }}</p> @enderror
            </div>
            <div class="form-group position-relative has-icon-left mb-4">
                <input type="email" class="form-control form-control-xl" name="email" placeholder="Email" value="{{ old('email') }}">
                <div class="form-control-icon">
                    <i class="bi bi-envelope"></i>
                </div>
                @error('email') <p style="color: rgb(220 38 38);">{{ $message }}</p> @enderror
            </div>
    
            <div class="form-group position-relative has-icon-left mb-4">
                <input type="password" class="form-control form-control-xl" name="password" placeholder="Password">
                <div class="form-control-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
                @error('password') <p style="color: rgb(220 38 38);">{{ $message }}</p> @enderror
            </div>
    
            <div class="form-group position-relative has-icon-left mb-4">
                <input type="password" class="form-control form-control-xl" name="password_confirmation" placeholder="Confirm Password">
                <div class="form-control-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
                @error('password_confirmation') <p style="color: rgb(220 38 38);">{{ $message }}</p> @enderror
            </div>

            <div class="form-group position-relative has-icon-left mb-4">
                <select class="form-control form-control-xl" name="office_id">
                    <livewire:office-livewire />
                </select>
                <div class="form-control-icon">
                    <i class="bi bi-building"></i>
                </div>
                @error('office_id') <p style="color: rgb(220 38 38);">{{ $message }}</p> @enderror
            </div>

            <div class="form-group position-relative has-icon-left mb-4">
                <label for="account_type">Account Types</label>
                <select class="form-select" size="5" id="account_type" name="account_type[]" multiple>
                    <livewire:account-type-livewire />
                </select>
                <p>Hold down the Ctrl (windows) or Command (Mac) button to select multiple options.</p>
                @error('account_type') <p style="color: rgb(220 38 38);">{{ $message }}</p> @enderror
            </div>
    
            {{-- <div class="form-group position-relative has-icon-left mb-4">
                <input type="text" class="form-control form-control-xl" name="account_types" placeholder="Account Types" value="{{ old('account_types') }}" title="Eg. Staff, Head of Delivery Unit, Head of Office, etc."
                <div class="form-control-icon">
                    <i class="bi bi-person-badge"></i>
                </div>
                <p class="text-muted">Eg. Staff, Head of Delivery Unit, Head of Office, etc.</p>
                @error('account_types') <p style="color: rgb(220 38 38);">{{ $message }}</p> @enderror
            </div> --}}


    
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>
    
                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif
    
            <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
        </form>
    </div>
</x-app-layout>
