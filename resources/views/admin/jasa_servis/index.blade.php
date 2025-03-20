@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <br>
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-white text-xl font-bold">Manajemen Jasa Servis</h1>
        <button onclick="openModal()" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition-all duration-200">
            + Tambah Jasa
        </button>
    </div>
    <br>

    <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Jenis Jasa</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700 text-white">
                @foreach($jasa_servis as $jasa)
                <tr class="hover:bg-gray-750 transition-colors">
                    <td class="px-4 py-3">{{ $jasa->id }}</td>
                    <td class="px-4 py-3">{{ $jasa->jenis }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($jasa->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 space-x-2 flex">
                        <button class="edit-btn bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-md"
                            data-id="{{ $jasa->id }}"
                            data-jenis="{{ $jasa->jenis }}"
                            data-harga="{{ $jasa->harga }}">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin.jasa_servis.destroy', $jasa->id) }}" class="inline">
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
            <h3 class="text-lg font-bold text-white" id="modalTitle">Tambah Jasa Servis</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-300 transition-colors">✖</button>
        </div>

        <form id="jasaForm" method="POST" action="{{ route('admin.jasa_servis.store') }}" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="method" name="_method" value="POST">

            <div class="space-y-3">
                <label class="block text-sm text-gray-400">Jenis Jasa</label>
                <input type="text" id="jenis" name="jenis" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">

                <label class="block text-sm text-gray-400">Harga</label>
                <input type="number" id="harga" name="harga" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="closeModal()" class="px-5 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-md">Batal</button>
                <button type="submit" class="ml-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('jasaForm').reset();
        document.getElementById('jasaForm').setAttribute('action', "{{ route('admin.jasa_servis.store') }}");
        document.getElementById('method').value = "POST";
        document.getElementById('modalTitle').textContent = "Tambah Jasa Servis";
        document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('jenis').value = this.dataset.jenis;
            document.getElementById('harga').value = this.dataset.harga;

            document.getElementById('method').value = "PUT";
            document.getElementById('jasaForm').setAttribute('action', `/admin/jasa_servis/${this.dataset.id}`);

            document.getElementById('modalTitle').textContent = "Edit Jasa Servis";
            document.getElementById('modal').classList.remove('hidden');
        });
    });
</script>
@endsection