@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <br>
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-white text-xl font-bold">Manajemen Pelanggan</h1>
        <button onclick="openModal()" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition-all duration-200">
            + Tambah Pelanggan
        </button>
    </div>
    <br>

    <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="px-4 py-3">KTP</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Alamat</th>
                    <th class="px-4 py-3">HP</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700 text-white">
                @foreach($pelanggan as $p)
                <tr class="hover:bg-gray-750 transition-colors">
                    <td class="px-4 py-3">{{ $p->ktp }}</td>
                    <td class="px-4 py-3">{{ $p->nama }}</td>
                    <td class="px-4 py-3">{{ $p->alamat }}</td>
                    <td class="px-4 py-3">{{ $p->hp }}</td>
                    <td class="px-4 py-3 space-x-2 flex">
                        <button class="edit-btn bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-md"
                            data-ktp="{{ $p->ktp }}" data-nama="{{ $p->nama }}" data-alamat="{{ $p->alamat }}" data-hp="{{ $p->hp }}">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin.pelanggan.destroy', $p->ktp) }}" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="modal" class="fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center hidden">
    <div class="bg-gray-900 rounded-lg shadow-xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0">
        <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white" id="modalTitle">Tambah Pelanggan</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-300 transition-colors">
                ✖
            </button>
        </div>

        <form id="pelangganForm" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="method" name="_method" value="POST">

            <div class="space-y-3">
                <div>
                    <label class="block text-sm text-gray-400">KTP</label>
                    <input type="text" id="ktp" name="ktp"
                        class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white placeholder-gray-500">
                </div>

                <div>
                    <label class="block text-sm text-gray-400">Nama</label>
                    <input type="text" id="nama" name="nama"
                        class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white placeholder-gray-500">
                </div>

                <div>
                    <label class="block text-sm text-gray-400">Alamat</label>
                    <input type="text" id="alamat" name="alamat"
                        class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white placeholder-gray-500">
                </div>

                <div>
                    <label class="block text-sm text-gray-400">HP</label>
                    <input type="text" id="hp" name="hp"
                        class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white placeholder-gray-500">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="closeModal()"
                    class="px-5 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-md">
                    Batal
                </button>
                <button type="submit"
                    class="ml-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        const modal = document.getElementById('modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.max-w-md').classList.remove('scale-95', 'opacity-0');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('modal');
        modal.querySelector('.max-w-md').classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);

        document.getElementById('pelangganForm').reset();
        document.getElementById('method').value = 'POST';
        document.getElementById('modalTitle').textContent = "Tambah Pelanggan";
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById('ktp').value = this.dataset.ktp;
                document.getElementById('ktp').setAttribute('readonly', true);
                document.getElementById('nama').value = this.dataset.nama;
                document.getElementById('alamat').value = this.dataset.alamat;
                document.getElementById('hp').value = this.dataset.hp;

                // **Ganti method ke PUT untuk update**
                document.getElementById('method').value = 'PUT';

                // **Pastikan action form benar**
                document.getElementById('pelangganForm').action = `/admin/pelanggan/${this.dataset.ktp}`;

                document.getElementById('modalTitle').textContent = "Edit Pelanggan";

                openModal();
            });
        });
    });
</script>
@endsection