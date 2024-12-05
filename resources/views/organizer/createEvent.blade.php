@extends('organizer.partials.sidebar')

@section('title', 'Create Event')

@section('content')
<main class="flex-1 p-0 px-2">
  <div class="bg-white shadow-md rounded-lg p-8">
    <h2 class="text-3xl font-bold mb-8 text-[#1B1464]">Create Event</h2>
    <form action="{{ route('organizer.storeEvent') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      @csrf
      
      <!-- Image Upload (Left Section) -->
      <div class="flex flex-col items-center">
        <label for="image" class="block text-gray-700 font-medium mb-4">Event Image</label>
        <div class="relative">
          <!-- Placeholder image -->
          <img id="image-preview" 
            src="https://via.placeholder.com/150" 
            alt="Event Image" 
            class="h-full w-full rounded-lg border object-cover cursor-pointer shadow-lg mb-4" 
            onclick="document.getElementById('image').click();">
          <input type="file" id="image" name="image" class="hidden" onchange="previewEventImage(event);">
        </div>
        <p class="text-gray-500 text-sm text-center">Click the image to upload.</p>
        @error('image')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
      </div>
      
      <!-- Form Fields (Right Section) -->
      <div class="col-span-2 space-y-4">
        <!-- Title Input -->
        <div>
          <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
          <input type="text" id="title" name="title" 
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            required>
          @error('title')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>
        
        <!-- Description Input -->
        <div>
          <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
          <textarea id="description" name="description" 
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            rows="3" required></textarea>
          @error('description')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <!-- Category Selection -->
        <div>
          <label for="category" class="block text-gray-700 font-medium mb-2">Category</label>
          <select id="category" name="id_category" 
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            required>
            <option value="" disabled selected>Select a category</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
          @error('id_category')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <!-- Date & Time Inputs -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="date" class="block text-gray-700 font-medium mb-2">Date</label>
            <input type="date" id="date" name="date" 
              class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
              required>
          </div>
          <div>
            <label for="time" class="block text-gray-700 font-medium mb-2">Time</label>
            <input type="time" id="time" name="time" 
              class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
              required>
          </div>
        </div>

        <!-- Location Inputs -->
        <div>
          <label for="location_name" class="block text-gray-700 font-medium mb-2">Location Name</label>
          <input type="text" id="location_name" name="location_name" 
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="city" class="block text-gray-700 font-medium mb-2">City</label>
            <input type="text" id="city" name="city" 
              class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
              required>
          </div>
          <div>
            <label for="province" class="block text-gray-700 font-medium mb-2">Province</label>
            <input type="text" id="province" name="province" 
              class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
              required>
          </div>
        </div>

        <!-- Price & Quota Inputs -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="price" class="block text-gray-700 font-medium mb-2">Price</label>
            <input type="number" id="price" name="price" 
              class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
          </div>
          <div>
            <label for="quota" class="block text-gray-700 font-medium mb-2">Quota</label>
            <input type="number" id="quota" name="quota" 
              class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
              required>
          </div>
        </div>
        
        <!-- Submit Button -->
        <div class="flex justify-between space-x-4">
          <button type="submit" 
            class="flex-1 bg-[#640D5F] text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition duration-300">
            Create Event
          </button>
          <a href="{{ route('organizer.manageEvents') }}" 
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
  function previewEventImage(event) {
    const preview = document.getElementById('image-preview');
    const file = event.target.files[0];
    if (file) {
      preview.src = URL.createObjectURL(file);
    }
  }
</script>
@endsection