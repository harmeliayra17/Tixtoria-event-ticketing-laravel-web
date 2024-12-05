@extends('admin.partials.sidebar')

@section('title', 'Manage Events')

@section('content')

<style>
    #success-message {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }
</style>

<!-- Success Message -->
@if(session('success'))
    <div id="success-message" class="fixed top-16 right-4 bg-green-500 text-white py-2 px-4 rounded-lg shadow-lg z-50 opacity-0">
        {{ session('success') }}
    </div>
@endif

<div class="mt-2 max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <!-- Create Event Button -->
    <div class="flex justify-end mt-4 md:mt-0 mb-4">
        <a href="{{ route('admin.createEvent') }}" class="flex items-center px-4 py-2 bg-[#640D5F] w-[160px] text-white text-sm font-semibold rounded-lg hover:bg-[#1B1464]">
            <span class="material-icons text-base mr-2">add_circle</span>
            Create Event
        </a>
    </div>

    <!-- Search Section -->
    <div class="flex justify-between items-center mb-4 flex-wrap">
        <section class="mt-2 mb-4 px-6 md:px-12 w-full">
            <form method="GET" action="{{ route('admin.manageEvents') }}" class="flex items-center space-x-0 w-full max-w-[700px] gap-4">
                @csrf
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search by event name or location" 
                    class="h-10 text-sm rounded-full px-4 border border-gray-300 focus:ring-2 focus:ring-[#640D5F] w-full sm:w-[200px]"
                />
                <select name="category" class="h-10 text-sm rounded-full px-4 border border-gray-300 focus:ring-2 focus:ring-[#640D5F]">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <input 
                    type="date" 
                    name="date" 
                    value="{{ request('date') }}" 
                    class="h-10 text-sm rounded-full px-4 border border-gray-300 focus:ring-2 focus:ring-[#640D5F] w-full sm:w-[150px]" 
                />
                <button type="submit" class="bg-[#640D5F] text-white px-6 py-2 rounded-full font-medium">
                    Search
                </button>
            </form>
        </section>
    </div>

    <!-- Events Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6">
        @foreach ($events as $event)
        <div class="bg-white shadow-md rounded-lg overflow-hidden flex">
            <!-- Card Image -->
            <div class="w-1/3 h-full bg-cover bg-center" 
                style="background-image: url('{{ $event->image ? asset($event->image) : 'https://via.placeholder.com/150' }}')">
            </div>

            <!-- Card Content -->
            <div class="w-2/3 p-4">
                <div class="mb-2">
                    @php
                        $date = \Carbon\Carbon::parse($event->date);
                    @endphp
                    <div class="text-[#1B1464] text-xs font-semibold">
                        <p>{{ $date->format('l') }}</p>
                        <p>{{ $date->format('d M Y') }}</p>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-800">{{ $event->title }}</h3>
                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($event->description, 80) }}</p>
                <div class="flex gap-4">
                    <a href="{{ route('admin.editEvent', $event->id) }}" 
                       class="text-white p-2 rounded-[5px] w-[50px] hover:shadow-lg transition duration-300 bg-[#640D5F]">
                       Edit
                    </a>
                    <button 
                        class="text-white p-2 rounded-[5px] w-[80px] hover:shadow-lg transition duration-300 bg-red-600" 
                        title="Delete Event" 
                        onclick="openDeleteModal({{ $event->id }})">
                        Delete
                    </button>
                </div>
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

<!-- Scripts -->
<script>
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
