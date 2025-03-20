@extends('layouts.admin')

@section('content')

<style>
    /* Styling Scrollbar */
    .scrollable-table {
        max-height: 500px;
        /* Atur tinggi maksimum agar bisa discroll */
        overflow-x: auto;
        scrollbar-width: thin;
        /* Untuk Firefox */
        scrollbar-color: #4a5568 #2d3748;
        /* Warna thumb dan track */
    }

    /* Scrollbar untuk Chrome, Edge, Safari */
    .scrollable-table::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .scrollable-table::-webkit-scrollbar-track {
        background: #2d3748;
        /* Warna background track */
        border-radius: 10px;
    }

    .scrollable-table::-webkit-scrollbar-thumb {
        background: rgba(90, 103, 216, 0.7);
        /* Warna scrollbar thumb */
        border-radius: 10px;
        transition: background 0.3s ease-in-out;
    }

    .scrollable-table::-webkit-scrollbar-thumb:hover {
        background: rgba(90, 103, 216, 1);
    }

    /* Sticky Column */
    .sticky-action {
        position: sticky;
        right: 0;
        background: rgba(23, 25, 35, 0.9);
        /* Efek kaca */
        backdrop-filter: blur(10px);
        box-shadow: -2px 0 4px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <br>
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-white text-xl font-bold">Manajemen Booking</h1>
        <button onclick="openModal()" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition-all duration-200">
            + Tambah Booking
        </button>
    </div>
    <br>

    <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden relative">
        <div class="scrollable-table">
            <table class="w-full text-left min-w-max">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="px-4 py-3">No Urut</th>
                        <th class="px-4 py-3">NIK</th>
                        <th class="px-4 py-3 whitespace-nowrap">Tanggal Booking</th>
                        <th class="px-4 py-3 whitespace-nowrap">Tanggal Penanganan</th>
                        <th class="px-4 py-3">Waktu Datang</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">No Antrian</th>
                        <th class="px-4 py-3">Nopol</th>
                        <th class="px-4 py-3">Merek</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3">Transmisi</th>
                        <th class="px-4 py-3">Kapasitas</th>
                        <th class="px-4 py-3">Tahun</th>
                        <th class="px-4 py-3 sticky-action border-l-2 border-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 text-white text-sm">
                    @foreach($bookings as $booking)
                    <tr class="hover:bg-gray-750 transition-colors">
                        <td class="px-4 py-3">{{ $booking->no_urut }}</td>
                        <td class="px-4 py-3">{{ $booking->nik }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $booking->tanggal_booking }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $booking->tanggal_penanganan }}</td>
                        <td class="px-4 py-3">{{ $booking->waktu_datang }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-lg text-xs font-semibold
        {{ $booking->status == 'Disetujui' ? 'bg-blue-500' : 
           ($booking->status == 'Dikerjakan' ? 'bg-yellow-500' : 
           ($booking->status == 'Selesai' ? 'bg-green-500' : 'bg-gray-500')) }}">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $booking->no_antrian_per_hari }}</td>
                        <td class="px-4 py-3">{{ $booking->nopol }}</td>
                        <td class="px-4 py-3">{{ $booking->merek }}</td>
                        <td class="px-4 py-3">{{ $booking->tipe }}</td>
                        <td class="px-4 py-3">{{ $booking->transmisi }}</td>
                        <td class="px-4 py-3">{{ $booking->kapasitas }}</td>
                        <td class="px-4 py-3">{{ $booking->tahun }}</td>
                        <td class="px-4 py-3 sticky-action">
                            <button class="edit-btn bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-md"
                                data-id="{{ $booking->no_urut }}"
                                data-nik="{{ $booking->nik }}"
                                data-tanggal_booking="{{ $booking->tanggal_booking }}"
                                data-tanggal_penanganan="{{ $booking->tanggal_penanganan }}"
                                data-waktu_datang="{{ $booking->waktu_datang }}"
                                data-status="{{ $booking->status }}"
                                data-no_antrian_per_hari="{{ $booking->no_antrian_per_hari }}"
                                data-nopol="{{ $booking->nopol }}"
                                data-merek="{{ $booking->merek }}"
                                data-tipe="{{ $booking->tipe }}"
                                data-transmisi="{{ $booking->transmisi }}"
                                data-kapasitas="{{ $booking->kapasitas }}"
                                data-tahun="{{ $booking->tahun }}">
                                Edit
                            </button>
                            <form method="POST" action="{{ route('admin.booking.destroy', $booking->no_urut) }}" class="inline">
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
</div>

<!-- Modal -->
<div id="modal" class="fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center hidden">
    <div class="bg-gray-900 rounded-lg shadow-xl w-full max-w-md transform transition-all duration-300">
        <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white" id="modalTitle">Tambah Booking</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-300 transition-colors">✖</button>
        </div>

        <form id="bookingForm" method="POST" action="{{ route('admin.booking.store') }}" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="method" name="_method" value="POST">

            <div class="space-y-3">
                <label class="block text-sm text-gray-400">NIK</label>
                <select id="nik" name="nik" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">
                    <option value="">-- Pilih NIK --</option>
                    @foreach($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->ktp }}">{{ $pelanggan->ktp }} - {{ $pelanggan->nama }}</option>
                    @endforeach
                </select>

                <label class="block text-sm text-gray-400">Tanggal Booking</label>
                <input type="date" id="tanggal_booking" name="tanggal_booking" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">

                <label class="block text-sm text-gray-400">Tanggal Penanganan</label>
                <input type="date" id="tanggal_penanganan" name="tanggal_penanganan" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">

                <label class="block text-sm text-gray-400">Waktu Datang</label>
                <input type="datetime-local" id="waktu_datang" name="waktu_datang" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">

                <label class="block text-sm text-gray-400">Status</label>
                <select id="status" name="status" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">
                    <option value="Menunggu">Menunggu</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Dikerjakan">Dikerjakan</option>
                    <option value="Selesai">Selesai</option>
                </select>

                <label class="block text-sm text-gray-400">No Antrian</label>
                <input type="text" id="no_antrian_per_hari" name="no_antrian_per_hari" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md text-white">

                <label class="block text-sm text-gray-400">Nopol</label>
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
        document.getElementById('bookingForm').reset();
        document.getElementById('modalTitle').textContent = "Tambah Booking";
        document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Ubah judul modal
            document.getElementById('modalTitle').textContent = "Edit Booking";

            // Ambil data dari tombol edit
            let id = this.dataset.id;
            let nik = this.dataset.nik;
            let tanggal_booking = this.dataset.tanggal_booking;
            let tanggal_penanganan = this.dataset.tanggal_penanganan;
            let status = this.dataset.status;
        let waktu_datang = this.dataset.waktu_datang;
            let no_antrian_per_hari = this.dataset.no_antrian_per_hari;
            let nopol = this.dataset.nopol;
            let merek = this.dataset.merek;
            let tipe = this.dataset.tipe;
            let transmisi = this.dataset.transmisi;
            let kapasitas = this.dataset.kapasitas;
            let tahun = this.dataset.tahun;

            // Isi nilai pada form modal
            document.getElementById('nik').value = nik;
            document.getElementById('tanggal_booking').value = tanggal_booking;
            document.getElementById('tanggal_penanganan').value = tanggal_penanganan;
            document.getElementById('waktu_datang').value = waktu_datang;
            document.getElementById('status').value = status;
            document.getElementById('no_antrian_per_hari').value = no_antrian_per_hari;
            document.getElementById('nopol').value = nopol;
            document.getElementById('merek').value = merek;
            document.getElementById('tipe').value = tipe;
            document.getElementById('transmisi').value = transmisi;
            document.getElementById('kapasitas').value = kapasitas;
            document.getElementById('tahun').value = tahun;

            // Ubah metode form menjadi PUT untuk update
            document.getElementById('method').value = "PUT";

            // Ubah action form ke update
            document.getElementById('bookingForm').action = `/admin/booking/${id}`;

            // Tampilkan modal
            document.getElementById('modal').classList.remove('hidden');
        });
    });
</script>
@endsection