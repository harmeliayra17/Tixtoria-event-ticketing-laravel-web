@extends('admin.partials.sidebar')

@section('title', 'Manage Users')

@section('content')
<div class="space-y-6 pb-12 w-full">
  @if(session('success'))
      <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
          <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
          <span class="text-sm font-medium">{{ session('success') }}</span>
      </div>
  @endif

  @if(!$pendingUsers->isEmpty())
    <div class="bg-white border border-slate-100 rounded-2xl shadow-md overflow-hidden">
      <div class="p-6 border-b border-slate-100 bg-amber-50/30 flex items-center justify-between">
          <div class="flex items-center gap-2.5">
              <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-850 flex items-center justify-center">
                  <i data-lucide="award" class="w-5 h-5 text-amber-800"></i>
              </div>
              <div>
                  <h2 class="text-base font-bold text-slate-800">Pending Organizer Applications</h2>
                  <p class="text-xs text-slate-500 mt-0.5">Review and approve user requests to become event organizers.</p>
              </div>
          </div>
          <span class="text-xs bg-amber-100 text-amber-800 font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider">
              {{ $pendingUsers->count() }} Request(s)
          </span>
      </div>
      <div class="overflow-x-auto">
          <table class="w-full table-auto border-collapse">
            <thead>
              <tr class="bg-slate-50 border-b border-slate-100 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                <th class="p-4 pl-6">Profile</th>
                <th class="p-4">Name</th>
                <th class="p-4">Email</th>
                <th class="p-4 pr-6 text-center">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
              @foreach ($pendingUsers as $pUser)
              <tr class="hover:bg-slate-50/50 transition">
                  <td class="p-4 pl-6">
                      <img src="{{ $pUser->profile ?? 'https://via.placeholder.com/40' }}" alt="Profile" class="w-10 h-10 rounded-full object-cover border border-slate-100">
                  </td>
                  <td class="p-4 font-semibold text-slate-800">{{ $pUser->name }}</td>
                  <td class="p-4 text-slate-600">{{ $pUser->email }}</td>
                  <td class="p-4 pr-6 text-center">
                    <div class="flex justify-center gap-3">
                        <form action="{{ route('admin.approveOrganizer', $pUser->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="h-9 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                Approve
                            </button>
                        </form>
                        <form action="{{ route('admin.rejectOrganizer', $pUser->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="h-9 px-4 bg-rose-50 border border-rose-100 hover:bg-rose-100 text-rose-600 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                Reject
                            </button>
                        </form>
                    </div>
                  </td>          
              </tr>
              @endforeach
            </tbody>    
          </table>
      </div>
    </div>
  @endif

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center justify-between">
      <div>
        <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Clients</span>
        <h3 class="text-3xl font-extrabold text-[#1B1464] mt-2">{{ $userCount }}</h3>
      </div>
      <div class="w-12 h-12 rounded-2xl bg-[#640D5F]/5 flex items-center justify-center">
        <i data-lucide="users" class="w-6 h-6 text-[#640D5F]"></i>
      </div>
    </div>

    
    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex items-center justify-between">
      <div>
        <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Organizers</span>
        <h3 class="text-3xl font-extrabold text-[#1B1464] mt-2">{{ $organizerCount }}</h3>
      </div>
      <div class="w-12 h-12 rounded-2xl bg-[#640D5F]/5 flex items-center justify-center">
        <i data-lucide="calendar" class="w-6 h-6 text-[#640D5F]"></i>
      </div>
    </div>
  </div>  

  
  <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4">
    
    <form action="{{ route('admin.manageUsers') }}" method="GET" class="flex items-center gap-3 w-full md:w-auto">
        <div class="relative w-full max-w-sm">
            <i data-lucide="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 w-4 h-4"></i>
            <input 
                type="text" 
                name="search" 
                placeholder="Search users by name or email..." 
                value="{{ request('search') }}" 
                class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl pl-12 pr-4 focus:outline-none focus:border-[#640D5F] text-sm"
            />
        </div>
        <button 
            type="submit" 
            class="h-11 px-6 bg-[#640D5F] text-white rounded-xl hover:brightness-110 active:scale-98 transition text-sm font-semibold flex items-center gap-2">
            Search
        </button>
    </form>

    
    <a 
        href="{{ route('admin.createUser') }}" 
        class="inline-flex items-center gap-1.5 px-5 py-3 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition duration-200 shadow-md">
        <i data-lucide="user-plus" class="w-4 h-4"></i>
        <span>Create User</span>
    </a>
  </div>

  
  <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100">
        <h2 class="text-lg font-bold text-[#1B1464]">User List</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse">
          <thead>
            <tr class="bg-slate-50 border-b border-slate-100 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
              <th class="p-4 pl-6">Profile</th>
              <th class="p-4">Name</th>
              <th class="p-4">Email</th>
              <th class="p-4">Role</th>
              <th class="p-4 pr-6 text-center">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-sm">
            @foreach ($users as $user)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="p-4 pl-6">
                    <img src="{{ $user->profile }}" alt="Profile" class="w-10 h-10 rounded-full object-cover border border-slate-100">
                </td>
                <td class="p-4 font-semibold text-slate-800">{{ $user->name }}</td>
                <td class="p-4 text-slate-600">{{ $user->email }}</td>
                <td class="p-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($user->role === 'admin') bg-purple-50 text-purple-700 border border-purple-200
                        @elseif($user->role === 'organizer') bg-blue-50 text-blue-700 border border-blue-200
                        @else bg-slate-100 text-slate-700 border border-slate-200
                        @endif">
                        {{ ucfirst($user->role) }}
                    </span>
                    @if($user->role === 'user' && $user->organizer_status === 'rejected')
                        <span class="text-[10px] text-rose-500 font-semibold block mt-0.5">(Application Rejected)</span>
                    @endif
                </td>
                <td class="p-4 pr-6 text-center">
                  <div class="flex justify-center gap-2">
                      
                      <a href="{{ route('admin.editUser', $user->id) }}" 
                         class="text-slate-600 p-2 bg-slate-50 border border-slate-200 rounded-xl hover:text-[#640D5F] hover:border-[#640D5F]/30 transition" 
                         title="Edit User">
                          <i data-lucide="edit-2" class="w-4 h-4"></i>
                      </a>
              
                      
                      <button 
                          class="text-rose-600 p-2 bg-rose-50 border border-rose-100 rounded-xl hover:bg-rose-100/50 transition" 
                          title="Delete User" 
                          onclick="openDeleteModal({{ $user->id }})">
                          <i data-lucide="trash-2" class="w-4 h-4"></i>
                      </button>
                  </div>
              </td>          
            </tr>
            @endforeach
          </tbody>    
        </table>
    </div>
  </div>
</div>


<div id="deleteModal" class="fixed inset-0 bg-slate-900 bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 border border-slate-100 mx-4">
        <h3 class="text-lg font-bold text-slate-900 mb-2">Delete User</h3>
        <p class="mb-6 text-sm text-slate-500 leading-relaxed">Are you sure you want to delete this user? This action cannot be undone and will delete all booking history linked to this account.</p>
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
  function openDeleteModal(userId) {
      const deleteModal = document.getElementById('deleteModal');
      const deleteForm = document.getElementById('deleteForm');
      deleteForm.action = "{{ route('admin.destroyUser', '') }}/" + userId;
      deleteModal.classList.remove('hidden');
  }

  function closeDeleteModal() {
      const deleteModal = document.getElementById('deleteModal');
      deleteModal.classList.add('hidden');
  }
</script>
@endsection
