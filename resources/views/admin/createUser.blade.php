@extends('admin.partials.sidebar')

@section('title', 'Create User')

@section('content')
<main class="w-full pb-12 animate-fade-in">
  <div class="bg-white border border-slate-100 rounded-2xl p-6 md:p-8 shadow-sm">
    <h2 class="text-xl font-bold text-[#1B1464] border-b border-slate-100 pb-4 mb-6">Create New User</h2>
    
    <form action="{{ route('admin.storeUser') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-8" autocomplete="off">
      @csrf
      
      
      <div class="flex flex-col items-center space-y-4">
        <label for="profile" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Profile Picture</label>
        <div class="relative w-32 h-32 rounded-full border border-slate-200 hover:border-[#640D5F] bg-slate-50/50 flex items-center justify-center cursor-pointer transition overflow-hidden group shadow-inner" onclick="document.getElementById('profile').click();">
          
          <img id="profile-preview" 
            src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=400&auto=format&fit=crop&q=80" 
            alt="Profile Preview" 
            class="absolute inset-0 h-full w-full object-cover transition duration-300 group-hover:scale-105 opacity-90">
          <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 transition duration-300">
            <i data-lucide="camera" class="w-6 h-6 mb-1"></i>
            <span class="text-[10px] font-bold">Upload</span>
          </div>
          <input type="file" id="profile" name="profile" class="hidden" onchange="previewProfileImage(event);">
        </div>
        <p class="text-[11px] text-slate-400 text-center">Click the picture to upload photo.</p>
        @error('profile')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
      </div>
      
      
      <div class="md:col-span-2 space-y-5">
        
        <div>
          <label for="name" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Name</label>
          <input type="text" id="name" name="name" 
            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm"
            required>
          @error('name')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>
        
        
        <div>
          <label for="email" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Email Address</label>
          <input type="email" id="email" name="email" 
            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm"
            required>
          @error('email')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>

        
        <div>
          <label for="password" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Password</label>
          <input type="password" id="password" name="password" 
            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm"
            required>
          @error('password')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>      

        
        <div>
          <label for="password_confirmation" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Confirm Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" 
            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm"
            required>
          @error('password_confirmation')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>
        
        
        <div>
          <label for="role" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Role</label>
          <div class="relative">
            <select id="role" name="role" 
              class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm focus:outline-none focus:border-[#640D5F] appearance-none cursor-pointer text-slate-500"
              required>
              <option value="user" selected>User</option>
              <option value="organizer">Organizer</option>
              <option value="admin">Admin</option>
            </select>
            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none text-slate-400">
              <i data-lucide="chevron-down" class="w-4 h-4"></i>
            </div>
          </div>
          @error('role')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>
        
        
        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
          <a href="{{ route('admin.manageUsers') }}" 
            class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 text-sm font-semibold transition">
            Cancel
          </a>
          <button type="submit" 
            class="px-5 py-2.5 bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white rounded-xl hover:brightness-110 active:scale-98 text-sm font-semibold transition shadow-md">
            Create User
          </button>
        </div>          
      </div>
    </form>
  </div>
</main>

<script>
  function previewProfileImage(event) {
    const preview = document.getElementById('profile-preview');
    const file = event.target.files[0];
    if (file) {
      preview.src = URL.createObjectURL(file);
    }
  }
</script>
@endsection
