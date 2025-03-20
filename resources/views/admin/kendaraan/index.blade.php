@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <br>
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-white text-xl font-bold">Manajemen Kendaraan</h1>
        <button onclick="openModal()" class="px-6 py-3 bg-blue-600 hover:bg-blue-600 text-white rounded-lg shadow-md transition-all duration-200">
            + Tambah Kendaraan
        </button>
    </div>
    <br>

    <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="px-4 py-3">No. Polisi</th>
                    <th class="px-4 py-3">Merek</th>
                    <th class="px-4 py-3">Tipe</th>
                    <th class="px-4 py-3">Transmisi</th>
                    <th class="px-4 py-3">Kapasitas</th>
                    <th class="px-4 py-3">Tahun</th>
                    <th class="px-4 py-3">Pemilik</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700 text-white">
                @foreach($kendaraan as $item)
                <tr class="hover:bg-gray-750 transition-colors">
                    <td class="px-4 py-3">{{ $item->nopol }}</td>
                    <td class="px-4 py-3">{{ $item->merek }}</td>
                    <td class="px-4 py-3">{{ $item->tipe }}</td>
                    <td class="px-4 py-3">{{ $item->transmisi }}</td>
                    <td class="px-4 py-3">{{ $item->kapasitas }}</td>
                    <td class="px-4 py-3">{{ $item->tahun }}</td>
                    <td class="px-4 py-3">{{ $item->pelanggan->nama }}</td>
                    <td class="px-4 py-3 space-x-2 flex">
                        <button class="edit-btn bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-md"
                            data-nopol="{{ $item->nopol }}"
                            data-merek="{{ $item->merek }}"
                            data-tipe="{{ $item->tipe }}"
                            data-transmisi="{{ $item->transmisi }}"
                            data-kapasitas="{{ $item->kapasitas }}"
                            data-tahun="{{ $item->tahun }}"
                            data-id_pelanggan="{{ $item->id_pelanggan }}">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin.kendaraan.destroy', $item->nopol) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md">
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
    <div class="bg-gray-900 rounded-lg shadow-xl w-full max-w-md transform transition-all duration-300">
        <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white" id="modalTitle">Tambah Kendaraan</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-300 transition-colors">✖</button>
        </div>

        <form id="kendaraanForm" method="POST" action="{{ route('admin.kendaraan.store') }}" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="method" name="_method" value="POST">

            <div class="space-y-3">
                <label class="block text-sm text-gray-400">No. Polisi</label>
                <input type="text" id="nopol" name="nopol" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">

                <label class="block text-sm text-gray-400">Merek</label>
                <input type="text" id="merek" name="merek" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">

                <label class="block text-sm text-gray-400">Tipe</label>
                <input type="text" id="tipe" name="tipe" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">

                <label class="block text-sm text-gray-400">Transmisi</label>
                <input type="text" id="transmisi" name="transmisi" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">

                <label class="block text-sm text-gray-400">Kapasitas</label>
                <input type="number" id="kapasitas" name="kapasitas" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">

                <label class="block text-sm text-gray-400">Tahun</label>
                <input type="number" id="tahun" name="tahun" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">

                <label class="block text-sm text-gray-400">Pemilik</label>
                <select id="id_pelanggan" name="id_pelanggan" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">
                    @foreach ($pelanggan as $p)
                    <option value="{{ $p->ktp }}">{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="closeModal()" class="px-5 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-md">Batal</button>
                <button type="submit" class="ml-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('nopol').value = this.dataset.nopol;
            document.getElementById('merek').value = this.dataset.merek;
            document.getElementById('tipe').value = this.dataset.tipe;
            document.getElementById('transmisi').value = this.dataset.transmisi;
            document.getElementById('kapasitas').value = this.dataset.kapasitas;
            document.getElementById('tahun').value = this.dataset.tahun;

            // Set pelanggan
            if (document.getElementById('id_pelanggan')) {
                document.getElementById('id_pelanggan').value = this.dataset.id_pelanggan;
            }

            // Ubah form menjadi metode PUT untuk update
            document.getElementById('method').value = "PUT";
            document.getElementById('kendaraanForm').setAttribute('action', `/admin/kendaraan/${this.dataset.nopol}`);

            document.getElementById('modalTitle').textContent = "Edit Kendaraan";
            document.getElementById('modal').classList.remove('hidden');
        });
    });

    function openModal() {
        document.getElementById('kendaraanForm').reset();
        document.getElementById('kendaraanForm').setAttribute('action', "{{ route('admin.kendaraan.store') }}");
        document.getElementById('method').value = "POST";
        document.getElementById('modalTitle').textContent = "Tambah Kendaraan";
        document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }
</script>
@endsection