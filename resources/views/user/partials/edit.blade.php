@extends('user.partials.sidebar')

@section('title', 'Profile Settings')

@section('content')
<div class="space-y-6 pb-12 w-full">
    
    <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-[#640D5F]/5 text-[#640D5F] flex items-center justify-center flex-shrink-0">
            <i data-lucide="settings" class="w-4 h-4"></i>
        </div>
        <p class="text-xs text-slate-500">Configure your personal information, update security credentials, and manage your account.</p>
    </div>

    
    <div class="bg-white border border-slate-100 rounded-2xl p-6 md:p-8 shadow-sm">
        <div class="max-w-xl">
            @include('user.partials.update-profile-information-form')
        </div>
    </div>

    
    <div class="bg-white border border-slate-100 rounded-2xl p-6 md:p-8 shadow-sm">
        <div class="max-w-xl">
            @include('user.partials.update-password-form')
        </div>
    </div>

    
    <div class="bg-white border border-rose-100 bg-rose-50/5 rounded-2xl p-6 md:p-8 shadow-sm">
        <div class="max-w-xl">
            @include('user.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
