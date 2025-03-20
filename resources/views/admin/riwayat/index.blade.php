@extends('layouts.admin')

@section('content')
<div class="max-w-1xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-white text-xl font-bold">Manajemen Riwayat</h1>
    <br><br>

    <!-- <button onclick="openModal()" class="mt-4 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md">
        + Tambah Riwayat
    </button> -->

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.riwayat.index') }}" class="mt-4">
        <div class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Hari</label>
                <select name="day" class="bg-gray-800 text-white rounded px-3 py-2">
                    <option value="">Semua Hari</option>
                    @for ($i = 1; $i <= 31; $i++)
                        <option value="{{ $i }}" {{ request('day') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Bulan</label>
                <select name="month" class="bg-gray-800 text-white rounded px-3 py-2">
                    <option value="">Semua Bulan</option>
                    @foreach(range(1, 12) as $month)
                    <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Tahun</label>
                <select name="year" class="bg-gray-800 text-white rounded px-3 py-2">
                    <option value="">Semua Tahun</option>
                    @foreach(range(date('Y'), date('Y') - 5) as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Filter
                </button>
                <a href="{{ route('admin.riwayat.index') }}" class="ml-2 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    Reset
                </a>
            </div>
        </div>
    </form>

    <div class="bg-gray-800 rounded-lg shadow-md mt-6 overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="px-4 py-3 text-xs">Tanggal</th>
                    <th class="px-4 py-3 text-xs">Keluhan</th>
                    <th class="px-4 py-3 text-xs">Penanganan</th>
                    <th class="px-4 py-3 text-xs">Catatan</th>
                    <th class="px-4 py-3 text-xs">Karyawan</th>
                    <th class="px-4 py-3 text-xs">Nomor Polisi</th>
                    <th class="px-4 py-3 text-xs">Jasa Servis</th>
                    <th class="px-4 py-3 text-xs">Sparepart</th>
                    <th class="px-4 py-3 text-xs">Pelanggan (KTP)</th>
                    <th class="px-4 py-3 text-xs">Status</th>
                    <th class="px-4 py-3 text-xs">Aksi</th>
                    <th class="px-4 py-3 text-xs">Total Harga</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700 text-white">
                @foreach($riwayats as $rw)
                <tr class="hover:bg-gray-750 transition-colors">
                    <td class="px-4 py-2 text-xs">{{ $rw->tanggal }}</td>
                    <td class="px-4 py-2 text-xs">{{ $rw->keluhan }}</td>
                    <td class="px-4 py-2 text-xs">{{ $rw->penanganan }}</td>
                    <td class="px-4 py-2 text-xs">{{ $rw->catatan }}</td>
                    <td class="px-4 py-2 text-xs">{{ $rw->karyawan->nama ?? '-' }}</td>
                    <td class="px-4 py-2 text-xs">{{ $rw->nopol }}</td>
                    <td class="px-4 py-2 text-xs">{{ $rw->jasaServis->jenis ?? '-' }}</td>
                    <td class="px-4 py-2 text-xs">
                        @if (!empty($rw->spareparts) && $rw->spareparts->isNotEmpty())
                        <ul>
                            @foreach ($rw->spareparts as $sp)
                            <li>{{ $sp->nama }} ({{ $sp->pivot->jumlah }} pcs)</li>
                            @endforeach
                        </ul>
                        @else
                        -
                        @endif
                    </td>
                    <td class="px-4 py-2 text-xs">{{ $rw->pelanggan->ktp ?? '-' }}</td>
                    <td class="px-4 py-2 text-xs">{{ ucfirst($rw->status) }}</td>
                    <td class="px-4 py-2 text-xs flex space-x-2">
                        <button class="edit-btn bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-md"
                            data-riwayat='@json($rw)'
                            onclick="editRiwayat(this)">
                            Edit Status
                        </button>
                        <!-- <form method="POST" action="{{ route('admin.riwayat.destroy', $rw->id) }}" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md">
                                Hapus
                            </button>
                        </form> -->
                        <a href="{{ route('admin.riwayat.invoice', $rw->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md">
                            Cetak Invoice
                        </a>
                    </td>
                    <td class="px-4 py-2 text-xs">Rp {{ number_format($rw->total_harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Edit Status -->
<div id="modal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-gray-900 rounded-lg shadow-xl w-full max-w-md p-6">
        <h3 class="text-lg font-bold text-white" id="modalTitle">Edit Status Riwayat</h3>

        <form id="riwayatForm" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" id="riwayat_id" name="riwayat_id">

            <div class="mt-3">
                <label class="block text-sm text-gray-400">Status</label>
                <select id="status" name="status" class="w-full px-4 py-2 bg-gray-800 text-white rounded">
                    <option value="Selesai">Selesai</option>
                    <option value="Sudah Dibayar">Sudah Dibayar</option>
                </select>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeModal()" class="px-5 py-2 bg-gray-700 text-white rounded-lg">Batal</button>
                <button type="submit" class="ml-4 px-5 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
        document.getElementById('riwayatForm').reset();
    }

    function editRiwayat(button) {
        let riwayat = JSON.parse(button.getAttribute('data-riwayat'));

        openModal();
        document.getElementById('modalTitle').textContent = "Edit Status Riwayat";

        document.getElementById('riwayat_id').value = riwayat.id;
        document.getElementById('status').value = riwayat.status;

        document.getElementById('riwayatForm').action = `{{ url('admin/riwayat') }}/${riwayat.id}`;
    }
</script>
@endsection