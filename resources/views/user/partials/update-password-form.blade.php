<section class="space-y-6">
    <header>
        <h3 class="text-lg font-bold text-[#1B1464]">
            {{ __('Update Password') }}
        </h3>
        <p class="mt-1 text-xs text-slate-500">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('user.password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="current_password" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Current Password</label>
            <input id="current_password" name="current_password" type="password" 
                class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm transition duration-200" autocomplete="current-password" />
            @error('current_password')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">New Password</label>
            <input id="password" name="password" type="password" 
                class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm transition duration-200" autocomplete="new-password" />
            @error('password')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" 
                class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm transition duration-200" autocomplete="new-password" />
            @error('password_confirmation')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white rounded-xl hover:brightness-110 active:scale-98 text-sm font-semibold transition shadow-md cursor-pointer">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs text-slate-500 font-semibold flex items-center gap-1"
                >
                    <i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>
                    <span>{{ __('Password updated successfully.') }}</span>
                </p>
            @endif
        </div>
    </form>
</section>
