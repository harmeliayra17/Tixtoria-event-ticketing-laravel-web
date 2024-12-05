@extends('user.partials.sidebar')

@section('content')
<div class="container mx-auto py-0">
    <h1 class="text-2xl font-bold mb-6">Your Favorites</h1>
    
    @if($favorites->isEmpty())
        <p class="text-gray-500">You have no favorites yet.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
            @foreach ($favorites as $favorite)
                <a 
                    href="{{ route('events.show', $favorite->event->id) }}" 
                    class="card bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 max-w-[300px] gap-20 mx-auto"
                >
                    <!-- Gambar Event -->
                    <img 
                        src="{{ $favorite->event->image ? asset($favorite->event->image) : 'https://via.placeholder.com/400x200' }}" 
                        alt="{{ $favorite->event->title }}" 
                        class="h-48 w-full object-cover"
                    >
                    
                    <div class="p-6">
                        <!-- Judul Event -->
                        <h3 class="text-xl font-bold text-gray-800 truncate">{{ $favorite->event->title }}</h3>
                        
                        <!-- Tanggal dan Hari -->
                        <p class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($favorite->event->date)->format('l, F j, Y') }}
                        </p>
                        
                        <!-- Deskripsi -->
                        <p class="mt-4 text-sm text-gray-600 truncate-lines">
                            {{ Str::limit($favorite->event->description, 120) }}
                        </p>
                        
                        <!-- Tombol Buy Tickets -->
                        <div class="mt-6 flex justify-between items-center">
                            <button 
                                class="text-sm bg-[#640D5F] text-white py-1 px-4 rounded hover:bg-purple-900"
                            >
                                Buy Tickets
                            </button>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
