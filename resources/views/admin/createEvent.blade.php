@extends('admin.partials.sidebar')

@section('title', 'Create Event')

@section('content')
<main class="w-full pb-12 animate-fade-in">
  <div class="bg-white border border-slate-100 rounded-2xl p-6 md:p-8 shadow-sm">
    <h2 class="text-xl font-bold text-[#1B1464] border-b border-slate-100 pb-4 mb-6">Create New Event</h2>
    
    <form action="{{ route('admin.storeEvent') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-8">
      @csrf
      
      <!-- Image Upload (Left Column) -->
      <div class="flex flex-col items-center space-y-4">
        <label for="image" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider text-center">Event Banner</label>
        <div class="relative w-full aspect-[4/3] rounded-2xl border-2 border-dashed border-slate-200 hover:border-[#640D5F] bg-slate-50/50 flex flex-col items-center justify-center cursor-pointer transition overflow-hidden group shadow-inner" onclick="document.getElementById('image').click();">
          <!-- Preview image -->
          <img id="image-preview" 
            src="https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&auto=format&fit=crop&q=80" 
            alt="Event Image Preview" 
            class="absolute inset-0 h-full w-full object-cover transition duration-300 group-hover:scale-105 opacity-90">
          <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 transition duration-300">
            <i data-lucide="upload-cloud" class="w-8 h-8 mb-2"></i>
            <span class="text-xs font-bold">Upload Image</span>
          </div>
          <input type="file" id="image" name="image" class="hidden" onchange="previewEventImage(event);">
        </div>
        <p class="text-[11px] text-slate-400 text-center">Click the container to upload banner image.</p>
        @error('image')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
      </div>
      
      <!-- Form Fields (Right Column) -->
      <div class="md:col-span-2 space-y-5">
        <!-- Title Input -->
        <div>
          <label for="title" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Event Title</label>
          <input type="text" id="title" name="title" 
            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm"
            required>
          @error('title')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>
        
        <!-- Description Input -->
        <div>
          <label for="description" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Description</label>
          <textarea id="description" name="description" 
            class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-[#640D5F] text-sm"
            rows="4" required></textarea>
          @error('description')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <!-- Category Selection -->
        <div>
          <label for="category" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Category</label>
          <div class="relative">
            <select id="category" name="id_category" 
              class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm focus:outline-none focus:border-[#640D5F] appearance-none cursor-pointer text-slate-500"
              required>
              <option value="" disabled selected>Select a category</option>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            </select>
            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none text-slate-400">
              <i data-lucide="chevron-down" class="w-4 h-4"></i>
            </div>
          </div>
          @error('id_category')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <!-- Date & Time Inputs -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="date" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Date</label>
            <input type="date" id="date" name="date" 
              class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm text-slate-500"
              required>
          </div>
          <div>
            <label for="time" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Time</label>
            <input type="time" id="time" name="time" 
              class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm text-slate-500"
              required>
          </div>
        </div>

        <!-- Location Name -->
        <div>
          <label for="location_name" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Location Venue Name</label>
          <input type="text" id="location_name" name="location_name" 
            class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm"
            required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="city" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">City</label>
            <input type="text" id="city" name="city" 
              class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm"
              required>
          </div>
          <div>
            <label for="province" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Province</label>
            <input type="text" id="province" name="province" 
              class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm"
              required>
          </div>
        </div>

        <!-- Price & Quota Inputs -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="price" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Price (Rp)</label>
            <input type="number" id="price" name="price" placeholder="0 for Free"
              class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm">
          </div>
          <div>
            <label for="quota" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Quota Capacity</label>
            <input type="number" id="quota" name="quota" 
              class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 focus:outline-none focus:border-[#640D5F] text-sm"
              required>
          </div>
        </div>
        
        <!-- Submit Button -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
          <a href="{{ route('admin.manageEvents') }}" 
            class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 text-sm font-semibold transition">
            Cancel
          </a>
          <button type="submit" 
            class="px-5 py-2.5 bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white rounded-xl hover:brightness-110 active:scale-98 text-sm font-semibold transition shadow-md">
            Create Event
          </button>
        </div>
      </div>
    </form>
  </div>
</main>

<script>
  function previewEventImage(event) {
    const preview = document.getElementById('image-preview');
    const file = event.target.files[0];
    if (file) {
      preview.src = URL.createObjectURL(file);
    }
  }
</script>
@endsection
