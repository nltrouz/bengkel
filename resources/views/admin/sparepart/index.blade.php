@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <br>
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-white text-xl font-bold">Manajemen Sparepart</h1>
        <button onclick="openModal()" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition-all duration-200">
            + Tambah Sparepart
        </button>
    </div>
    <br>

    <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="px-4 py-3">Kode</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Jumlah</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700 text-white">
                @foreach($spareparts as $sp)
                <tr class="hover:bg-gray-750 transition-colors">
                    <td class="px-4 py-3">{{ $sp->kode }}</td>
                    <td class="px-4 py-3">{{ $sp->nama }}</td>
                    <td class="px-4 py-3">{{ $sp->jumlah }}</td>
                    <td class="px-4 py-3">Rp{{ number_format($sp->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 space-x-2 flex">
                        <button class="edit-btn bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-md"
                            onclick="editSparepart('{{ $sp->kode }}', '{{ $sp->nama }}', '{{ $sp->jumlah }}', '{{ $sp->harga }}')">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin.sparepart.destroy', $sp->kode) }}" onsubmit="return confirm('Yakin ingin menghapus?')">
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
<div id="modal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-gray-900 rounded-lg shadow-xl w-full max-w-md p-6 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
        <div class="flex justify-between items-center border-b border-gray-700 pb-4">
            <h3 class="text-lg font-bold text-white" id="modalTitle">Tambah Sparepart</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-300">✖</button>
        </div>

        <form id="sparepartForm" method="POST" action="{{ route('admin.sparepart.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" id="method" name="_method" value="POST">

            <div>
                <label class="block text-sm text-gray-400">Kode</label>
                <input type="text" id="kode" name="kode" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400">Nama</label>
                <input type="text" id="nama" name="nama" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400">Jumlah</label>
                <input type="number" id="jumlah" name="jumlah" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400">Harga</label>
                <input type="number" id="harga" name="harga" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="closeModal()" class="px-5 py-2 bg-gray-700 text-white rounded-md">Batal</button>
                <button type="submit" class="ml-4 px-5 py-2 bg-blue-600 text-white rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modal').classList.remove('hidden');
        document.getElementById('modalContent').classList.remove('scale-95', 'opacity-0');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
        document.getElementById('sparepartForm').reset();
        document.getElementById('sparepartForm').action = "{{ route('admin.sparepart.store') }}";
        document.getElementById('method').value = "POST";
        document.getElementById('modalTitle').textContent = "Tambah Sparepart";
    }

    function editSparepart(kode, nama, jumlah, harga) {
        openModal();
        document.getElementById('kode').value = kode;
        document.getElementById('nama').value = nama;
        document.getElementById('jumlah').value = jumlah;
        document.getElementById('harga').value = harga;
        document.getElementById('modalTitle').textContent = "Edit Sparepart";
        document.getElementById('sparepartForm').action = `/admin/sparepart/${kode}`;
        document.getElementById('method').value = "PUT";
    }
</script>
@endsection
