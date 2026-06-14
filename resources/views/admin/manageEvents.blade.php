@extends('admin.partials.sidebar')

@section('title', 'Manage Events')

@section('content')
<div class="space-y-6 pb-12 w-full animate-fade-in">
    
    
    <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-[#640D5F]/5 text-[#640D5F] flex items-center justify-center flex-shrink-0">
                <i data-lucide="calendar" class="w-4 h-4"></i>
            </div>
            <p class="text-xs text-slate-500">Supervise and manage all event listings across the platform.</p>
        </div>
        <a href="{{ route('admin.createEvent') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white text-xs font-semibold rounded-xl hover:brightness-110 active:scale-95 transition-all shadow-md">
            <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
            <span>Create Event</span>
        </a>
    </div>

    
    @if(session('success'))
        <div id="success-banner" class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 flex items-center gap-3 text-emerald-800 text-sm">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        <script>
            setTimeout(() => {
                const banner = document.getElementById('success-banner');
                if(banner) {
                    banner.style.opacity = '0';
                    banner.style.transition = 'opacity 0.5s ease-out';
                    setTimeout(() => banner.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6">
        <form method="GET" action="{{ route('admin.manageEvents') }}" class="flex flex-col md:flex-row items-center gap-4">
            @csrf
            
            
            <div class="relative w-full flex-[2]">
                <i data-lucide="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 w-4.5 h-4.5"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search by event name or venue..." 
                    class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl pl-12 pr-4 focus:outline-none focus:border-[#640D5F] text-sm"
                />
            </div>
            
            
            <div class="relative w-full flex-[1]">
                <select name="category" class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-4 text-sm focus:outline-none focus:border-[#640D5F] appearance-none cursor-pointer text-slate-500">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none text-slate-400">
                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                </div>
            </div>
            
            
            <div class="relative w-full flex-[1]">
                <i data-lucide="calendar" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 w-4 h-4"></i>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl pl-12 pr-4 focus:outline-none focus:border-[#640D5F] text-sm text-slate-500" />
            </div>
            
            <button type="submit" class="w-full md:w-auto h-11 bg-gradient-to-r from-[#640D5F] to-[#1B1464] text-white px-6 rounded-xl font-semibold hover:brightness-110 active:scale-95 transition-all flex items-center justify-center text-sm">
                Search
            </button>
        </form>
    </div>

    
    <div class="grid grid-cols-1 gap-6">
        @forelse ($events as $event)
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden flex flex-col md:flex-row h-auto md:h-48 group">
            
            <div class="w-full md:w-1/3 h-48 md:h-full bg-slate-100 overflow-hidden relative">
                <img src="{{ Str::startsWith($event->image, ['http://', 'https://']) ? $event->image : ($event->image ? asset($event->image) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&auto=format&fit=crop&q=80') }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <span class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[#640D5F] text-[9px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">
                    {{ $event->category->name }}
                </span>
            </div>

            
            <div class="w-full md:w-2/3 p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-1.5 text-[#640D5F] text-xs font-semibold">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        <span>{{ date('D, d M Y', strtotime($event->date)) }} - {{ date('H:i', strtotime($event->time)) }} WIB</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mt-2 line-clamp-1">{{ $event->title }}</h3>
                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $event->description }}</p>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-4 text-xs font-medium text-slate-400">
                        <span class="flex items-center gap-1">
                            <i data-lucide="ticket" class="w-4 h-4 text-slate-400"></i>
                            <span class="text-slate-700 font-bold">{{ $event->quota }}</span> slots
                        </span>
                        <span class="flex items-center gap-1">
                            <i data-lucide="dollar-sign" class="w-4 h-4 text-slate-400"></i>
                            <span class="text-[#640D5F] font-bold">
                                @if($event->price > 0)
                                    Rp{{ number_format($event->price, 0, ',', '.') }}
                                @else
                                    Free
                                @endif
                            </span>
                        </span>
                    </div>

                    
                    <div class="flex gap-2">
                        <a href="{{ route('admin.editEvent', $event->id) }}" 
                           class="inline-flex items-center gap-1 px-4 py-2 bg-slate-50 border border-slate-200 text-slate-600 hover:text-[#640D5F] hover:border-[#640D5F]/30 rounded-xl text-xs font-semibold transition">
                           <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                           <span>Edit</span>
                        </a>
                        <button 
                            class="inline-flex items-center gap-1 px-4 py-2 bg-rose-50 border border-rose-100 text-rose-600 hover:bg-rose-100/50 rounded-xl text-xs font-semibold transition" 
                            title="Delete Event" 
                            onclick="openDeleteModal({{ $event->id }})">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            <span>Delete</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="text-center py-16 bg-white border border-slate-100 rounded-2xl shadow-sm">
                <i data-lucide="calendar" class="w-12 h-12 text-slate-300 mx-auto mb-4"></i>
                <h3 class="text-lg font-bold text-slate-700">No Events Managed</h3>
                <p class="text-slate-500 mt-2 text-xs">No events are currently registered on the platform.</p>
                <a href="{{ route('admin.createEvent') }}" class="mt-6 inline-flex items-center gap-2 bg-[#640D5F] text-white px-6 py-2.5 rounded-xl text-xs font-semibold hover:brightness-110 transition">Create Event</a>
            </div>
        @endforelse
    </div>

    
    <div class="mt-6">
        {{ $events->links() }}
    </div>
</div>


<div id="deleteModal" class="fixed inset-0 bg-slate-900 bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 border border-slate-100 mx-4">
        <h3 class="text-lg font-bold text-slate-900 mb-2">Delete Event</h3>
        <p class="mb-6 text-sm text-slate-500 leading-relaxed">Are you sure you want to delete this event? This action will cancel all future bookings and cannot be undone.</p>
        <div class="flex justify-end space-x-3">
            <button 
                onclick="closeDeleteModal()" 
                class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 text-sm font-semibold transition">
                Cancel
            </button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-rose-600 text-white rounded-xl hover:bg-rose-700 text-sm font-semibold transition shadow-md">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

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
