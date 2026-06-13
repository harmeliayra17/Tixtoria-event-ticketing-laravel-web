<section class="space-y-6">
    <header>
        <h3 class="text-lg font-bold text-[#1B1464]">
            {{ __('Profile Information') }}
        </h3>
        <p class="mt-1 text-xs text-slate-500">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('user.profile.update') }}" class="space-y-5">
        @csrf
        @method('PATCH')

        <div>
            <label for="name" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Name</label>
            <input id="name" name="name" type="text" 
                class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm transition duration-200" 
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Email Address</label>
            <input id="email" name="email" type="email" 
                class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm transition duration-200" 
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 bg-amber-50 border border-amber-100 rounded-xl p-3 text-xs text-amber-800">
                    <p>
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline font-bold text-[#640D5F] hover:text-[#1B1464] transition">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-semibold text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white rounded-xl hover:brightness-110 active:scale-98 text-sm font-semibold transition shadow-md cursor-pointer">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs text-slate-500 font-semibold flex items-center gap-1"
                >
                    <i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>
                    <span>{{ __('Saved successfully.') }}</span>
                </p>
            @endif
        </div>
    </form>
</section>
