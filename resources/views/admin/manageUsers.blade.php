@extends('admin.partials.sidebar')

@section('title', 'Manage Users')

@section('content')


<main class="flex-1 p-0 bg-gray-100">
  <!-- Informasi Jumlah User dan EO -->
  <div class="grid grid-cols-2 gap-6 mb-6">
  <!-- Card 1: User Count -->
  <div class="bg-gradient-to-r from-[#640D5F] to-[#1B1464] shadow p-4 rounded-lg flex flex-col justify-between items-center">
    <span class="material-icons text-4xl mb-2 text-white">group</span>
    <span class="text-lg font-bold text-white">User</span>
    <span class="text-2xl font-semibold text-white">{{ $userCount }}</span>
  </div>

  <!-- Card 2: Organizer Count -->
  <div class="bg-gradient-to-r from-[#640D5F] to-[#1B1464] shadow p-4 rounded-lg flex flex-col justify-between items-center">
    <span class="material-icons text-4xl mb-2 text-white">event</span>
    <span class="text-lg font-bold text-white">Organizer</span>
    <span class="text-2xl font-semibold text-white">{{ $organizerCount }}</span>
  </div>

  </div>  

  <!-- Form Pencarian dan Tombol Create User -->
  <div class="flex justify-between items-center mb-4">
    <!-- Form Pencarian -->
    <form action="{{ route('admin.manageUsers') }}" method="GET" class="flex items-center space-x-2">
        <div class="relative w-full max-w-sm">
            <input 
                type="text" 
                name="search" 
                placeholder="Search users..." 
                value="{{ request('search') }}" 
                class="w-full px-4 py-2 border border-[#640D5F] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#640D5F]"
            />
        </div>
        <button 
            type="submit" 
            class="flex items-center px-4 py-2 bg-[#640D5F] text-white rounded-lg hover:bg-[#41083e] transition duration-300">
            <i class="fa fa-search mr-2"></i> Search
        </button>
    </form>

    <!-- Tombol Create User -->
    <a 
        href="{{ route('admin.createUser') }}" 
        class="flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
        <span class="material-icons mr-2">
            person_add
        </span>
        Create User
    </a>
  </div>


  <!-- Daftar Pengguna -->
  <div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-bold mb-4">Daftar Pengguna</h2>
    <table class="w-full table-auto border-collapse">
      <thead>
        <tr class="text-left bg-gray-200">
          <th class="p-4">Profile</th>
          <th class="p-4">Nama</th>
          <th class="p-4">Email</th>
          <th class="p-4">Role</th>
          <th class="p-4 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
        <tr class="border-b text-sm">
            <td class="p-4">
                <img src="{{ $user->profile }}" alt="Profile" class="w-10 h-10 rounded-full object-cover">
            </td>
            <td class="p-4">{{ $user->name }}</td>
            <td class="p-4">{{ $user->email }}</td>
            <td class="p-4">{{ ucfirst($user->role) }}</td>
            <td class="p-4 text-center">
              <div class="flex justify-center gap-4">
                  <!-- Tombol Edit -->
                  <a href="{{ route('admin.editUser', $user->id) }}" 
                     class="text-white p-2 rounded-full hover:shadow-lg transition duration-300" 
                     style="background-color: #640D5F" 
                     title="Edit User">
                      <span class="material-icons">edit</span>
                  </a>
          
                  <!-- Tombol Delete -->
                  <button 
                      class="text-white p-2 rounded-full hover:shadow-lg transition duration-300" 
                      style="background-color: #af0c0c" 
                      title="Delete User" 
                      onclick="openDeleteModal({{ $user->id }})">
                      <span class="material-icons">delete</span>
                  </button>
              </div>
          </td>          
          </tr>
         @endforeach
     </tbody>    
    </table>
  </div>
</main>
@endsection

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
  <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
      <h3 class="text-xl font-bold mb-4">Confirm Deletion</h3>
      <p class="mb-6 text-gray-700">Are you sure you want to delete this user? This action cannot be undone.</p>
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
