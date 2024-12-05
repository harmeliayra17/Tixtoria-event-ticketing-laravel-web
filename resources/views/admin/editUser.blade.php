@extends('admin.partials.sidebar')

@section('title', 'Edit User')

@section('content')
<main class="flex-1 p-0 px-2">
  <div class="bg-white shadow-md rounded-lg p-8">
    <h2 class="text-3xl font-bold mb-8 text-[#1B1464]]">Edit User</h2>
    <form action="{{ route('admin.updateUser', $user->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      @csrf
      @method('PUT')
      
      <!-- Profile Picture (Left Section) -->
      <div class="flex flex-col items-center">
        <label for="profile" class="block text-gray-700 font-medium mb-4">Profile Picture</label>
        <div class="relative">
          <!-- Show existing profile picture -->
          <img id="profile-preview" 
            src="{{ old('profile', $user->profile ? asset($user->profile) : 'https://via.placeholder.com/150') }}" 
            alt="Profile Picture" 
            class="h-32 w-32 rounded-full border object-cover cursor-pointer shadow-lg mb-4" 
            onclick="document.getElementById('profile').click();">
          <input type="file" id="profile" name="profile" class="hidden" onchange="previewImage(event);">
        </div>
        <p class="text-gray-500 text-sm text-center">Click the picture to change it.</p>
      </div>
      
      <!-- Form Fields (Right Section) -->
      <div class="col-span-2 space-y-4">
        <!-- Name Input -->
        <div>
          <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
          <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            required>
        </div>
        
        <!-- Email Input -->
        <div>
          <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            required>
        </div>

        <div>
          <label for="password" class="block text-gray-700 font-medium mb-2">
              New Password <span class="text-gray-500 text-sm">(Leave empty to keep current password)</span>
          </label>
          <input type="password" id="password" name="password" 
              class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
          @error('password')
              <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
      </div>      

      <div>
        <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">
            Confirm New Password
        </label>
        <input type="password" id="password_confirmation" name="password_confirmation" 
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
          @error('password_confirmation')
              <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
      </div>
        
        <!-- Role Selection -->
        <div>
          <label for="role" class="block text-gray-700 font-medium mb-2">Role</label>
          <select id="role" name="role" 
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            required>
            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
            <option value="organizer" {{ old('role', $user->role) == 'organizer' ? 'selected' : '' }}>Organizer</option>
            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
          </select>
        </div>
        
        <!-- Submit Button -->
        <div class="flex justify-between space-x-4">
            <!-- Save Changes Button -->
            <button type="submit" 
              class="flex-1 bg-[#640D5F] text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition duration-300">
              Save Changes
            </button>
            
            <!-- Cancel Button -->
            <a href="{{ route('admin.manageUsers') }}" 
              class="flex-1 text-center bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-400 transition duration-300">
              Cancel
            </a>
          </div>          
      </div>
    </form>
  </div>
</main>

<script>
  // Preview selected image
  function previewImage(event) {
    const preview = document.getElementById('profile-preview');
    const file = event.target.files[0];
    if (file) {
      preview.src = URL.createObjectURL(file);
      
    }
  }

  // Reset to the original image
  function resetImage(originalSrc) {
    const preview = document.getElementById('profile-preview');
    const fileInput = document.getElementById('profile');
    preview.src = originalSrc;
    fileInput.value = ''; 
  }

</script>
@endsection
