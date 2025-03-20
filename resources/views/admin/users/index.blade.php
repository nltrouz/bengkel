@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-white text-xl font-bold">Manajemen Users</h1>
            <button onclick="openModal()"
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition-all duration-200">
                + Tambah User
            </button>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="px-4 py-3">NIK KTP</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 text-white">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-750 transition-colors">
                            <td class="px-4 py-3">{{ $user->nik_ktp }}</td>
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ ucfirst($user->role) }}</td>
                            <td class="px-4 py-3 space-x-2 flex">
                                <button class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-md"
                                    onclick="editUser('{{ $user->nik_ktp }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">
                                    Edit
                                </button>
                                <form action="{{ route('admin.users.destroy', $user->nik_ktp) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal"
        class="fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center hidden">
        <div id="modalContent"
            class="bg-gray-900 rounded-lg shadow-xl w-full max-w-md transform transition-all duration-300 opacity-0 scale-95">
            <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white" id="modalTitle">Tambah User</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-300 transition-colors">✖</button>
            </div>

            <form id="userForm" method="POST" action="{{ route('admin.users.store') }}" class="p-6 space-y-4">
                @csrf
                <input type="hidden" id="method" name="_method" value="PUT">
                <input type="hidden" id="userId" name="id">

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm text-gray-400">NIK KTP</label>
                        <input type="number" id="nik_ktp" name="nik_ktp"
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white" required>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400">Nama</label>
                        <input type="text" id="name" name="name"
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white" required>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white" required>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400">Password</label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400">Role</label>
                        <select id="role" name="role"
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()"
                        class="px-5 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-md">Batal</button>
                    <button type="submit"
                        class="ml-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            let modal = document.getElementById('modal');
            let modalContent = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('opacity-0', 'scale-95');
            }, 10);

            document.getElementById('userForm').reset();
            document.getElementById('modalTitle').innerText = 'Tambah User';
            document.getElementById('userForm').action = "{{ route('admin.users.store') }}";
            document.getElementById('method').value = "POST";
        }

        function closeModal() {
            let modal = document.getElementById('modal');
            let modalContent = document.getElementById('modalContent');

            modalContent.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        function editUser(nik_ktp, name, email, role) {
            console.log("Edit User Dipanggil:", nik_ktp, name, email, role);  // Debugging

            openModal();

            document.getElementById('modalTitle').innerText = 'Edit User';
            document.getElementById('nik_ktp').value = nik_ktp;
            document.getElementById('name').value = name;
            document.getElementById('email').value = email;
            document.getElementById('role').value = role;

            // Pastikan form mengarah ke URL update
            document.getElementById('userForm').action = `/admin/users/${nik_ktp}`;
            document.getElementById('method').value = "PUT";
        }
    </script>
@endsection