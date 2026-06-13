<section class="space-y-6">
    <header>
        <h3 class="text-lg font-bold text-rose-600">
            {{ __('Delete Account') }}
        </h3>
        <p class="mt-1 text-xs text-slate-500">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please make sure to download any data you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-5 py-2.5 bg-rose-600 text-white rounded-xl hover:bg-rose-700 text-sm font-semibold transition shadow-md active:scale-98 cursor-pointer"
    >
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('user.profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h3 class="text-lg font-bold text-slate-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h3>

            <p class="mt-2 text-xs text-slate-500 leading-relaxed">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-5">
                <label for="password" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm"
                    placeholder="{{ __('Enter your account password') }}"
                    required
                />
                @error('password', 'userDeletion')
                    <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 text-sm font-semibold transition">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="px-5 py-2.5 bg-rose-600 text-white rounded-xl hover:bg-rose-700 text-sm font-semibold transition shadow-md">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
