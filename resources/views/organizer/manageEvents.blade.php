@extends('organizer.partials.sidebar')

@section('title', 'Manage Events')

@section('content')

<style>
    #success-message {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }
</style>

<!-- Success Message (displayed on successful update) -->
@if(session('success'))
    <div id="success-message" class="fixed top-16 right-4 bg-green-500 text-white py-2 px-4 rounded-lg shadow-lg z-50 opacity-0">
        {{ session('success') }}
    </div>
@endif

<!-- Manage Events Section -->
<div class="mt-2 max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <!-- Search and Create Event Button -->
    <div class="flex justify-between items-center mb-4 flex-wrap">
        <!-- Search Section -->
        <section class="mt-2 mb-4 px-6 md:px-12 w-full">
            <div class="relative">
                <form method="GET" action="{{ route('organizer.manageEvents') }}" class="flex items-center space-x-0 w-full max-w-[700px] gap-4">
                    @csrf
                
                    <!-- Search by Name or Location -->
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search by event name or location" 
                        class="h-10 text-sm rounded-full px-4 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#640D5F] w-full sm:w-[200px]"
                    />            
                    
                    <!-- Category Filter -->
                    <select name="category" class="h-10 text-sm rounded-full px-4 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#640D5F]">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    
                    <!-- Filter by Date -->
                    <input type="date" name="date" value="{{ request('date') }}" class="h-10 text-sm rounded-full px-4 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#640D5F] w-full sm:w-[150px]" />
                    
                    <!-- Submit Button -->
                    <button type="submit" class="bg-[#640D5F] text-white px-6 py-2 rounded-full font-medium w-full sm:w-auto">
                        Search
                    </button>
                </form>
            </div>
        </section>
    </div>

    <div class="flex justify-end mt-4 md:mt-0 mb-4">
        <a href="{{ route('organizer.createEvent') }}" class="flex items-center px-4 py-2 bg-[#640D5F] w-[160px] text-white text-sm font-semibold rounded-lg hover:bg-[#1B1464]">
            <span class="material-icons text-base mr-2" style="justify-content: flex-end">add_circle</span>
            Create Event
        </a>
    </div>

    <!-- Events Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6">
        @foreach ($events as $event)
        <div class="bg-white shadow-md rounded-lg overflow-hidden flex shadow-lg">
        <!-- Card Image (Kiri) -->
        <div class="w-1/3 h-full bg-cover bg-center" 
            style="background-image: url('{{ $event->image ? asset($event->image) : 'https://via.placeholder.com/150' }}')">
        </div>


            <!-- Card Content (Kanan) -->
            <div class="w-2/3 p-4">
                <!-- Date and Day -->
                <div class="mb-2">
                    @php
                        $date = \Carbon\Carbon::parse($event['date']);
                        $day = $date->format('l'); // Hari
                        $formattedDate = $date->format('d M Y'); // Tanggal
                    @endphp
                    <div class="text-[#1B1464] text-xs font-semibold">
                        <p>{{ $day }}</p>
                        <p>{{ $formattedDate }}</p>
                    </div>
                </div>

                <!-- Event Title -->
                <h3 class="text-lg font-bold text-gray-800">{{ $event['title'] }}</h3>
                
                <!-- Event Description -->
                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($event['description'], 80) }}</p>

                <!-- Manage Button -->
                <div class="flex gap-4">
                    <a href="{{ route('admin.editEvent', $event->id) }}" 
                       class="text-white p-2 rounded-[20px] hover:shadow-lg transition duration-300 bg-[#640D5F]">
                       Edit
                    </a>
                    <button 
                        class="text-white p-2 rounded-[20px] hover:shadow-lg transition duration-300 bg-red-600" 
                        title="Delete Event" 
                        onclick="openDeleteModal({{ $event->id }})">
                        Delete
                    </button>
                </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>


    <!-- Pagination -->
    <div class="mt-6">
        {{ $events->links() }}
    </div>
</div>

<!-- Modal for Delete Confirmation -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
        <h3 class="text-xl font-bold mb-4">Confirm Deletion</h3>
        <p class="mb-6 text-gray-700">Are you sure you want to delete this event? This action cannot be undone.</p>
        <div class="flex justify-end space-x-4">
            <button 
                onclick="closeDeleteModal()" 
                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                Cancel
            </button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.getElementById('success-message');
    if (successMessage) {
      // Ensure the success message is visible immediately after the page loads
      successMessage.style.opacity = '1'; // Make the message visible by setting opacity to 1
      successMessage.style.display = 'block'; // Ensure the message is displayed

      // Hide the success message after 3 seconds
      setTimeout(function() {
        successMessage.style.opacity = '0'; // Fade out the message
      }, 3000); // Adjust this time as needed
    }
  });

  function openDeleteModal(eventId) {
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = "{{ route('admin.deleteEvent', '') }}/" + eventId;
        deleteModal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
