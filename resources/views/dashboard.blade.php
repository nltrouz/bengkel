<x-app-layout>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <!-- Hero Section -->
        <div class="relative py-16 bg-gradient-to-r from-orange-500/10 to-transparent">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-white mb-4 animate-fade-in-down">
                        Selamat Datang, <span class="text-orange-400">{{ Auth::user()->name }}</span>! 🏍️
                    </h1>
                    <p class="text-xl text-gray-300 mb-8">
                        Layanan servis motor profesional dengan garansi terjamin
                    </p>
                </div>
            </div>

            <div x-data="{ open: false }" x-init="open = false">
                <!-- Tombol Book Now -->
                <div class="flex justify-center">
                    <button @click="open = true"
                        class="relative overflow-hidden bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white px-8 py-4 rounded-2xl
               text-xl transition-all duration-500 transform hover:scale-105 shadow-2xl
               before:absolute before:inset-0 before:bg-gradient-to-r before:from-white/20 before:to-transparent
               before:opacity-0 hover:before:opacity-100 before:transition-opacity before:duration-500
               hover:shadow-red-500/30 text-center inline-block">
                        <span class="relative z-10 flex items-center justify-center space-x-3">
                            <span>Booking Sekarang Juga</span>
                            <i class="fas fa-calendar-check animate-pulse"></i>
                        </span>
                    </button>
                </div>

                <!-- Booking Form (Default Hidden) -->
                <div x-cloak x-show="open"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-90"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">

                    <div class="relative bg-gray-800 rounded-3xl shadow-2xl shadow-orange-500/20 border border-gray-700 p-8 w-full max-w-2xl mx-4">
                        <!-- Header -->
                        <div class="flex justify-between items-center pb-4 border-b border-gray-600">
                            <h3 class="text-2xl font-bold text-white">
                                <i class="fas fa-motorcycle mr-2 text-orange-400"></i>Booking AbakuraRacing Services
                            </h3>
                            <button @click="open = false" class="p-2 hover:bg-gray-700 rounded-full transition-all duration-200">
                                <i class="fas fa-times text-xl text-gray-400 hover:text-orange-400"></i>
                            </button>
                        </div>

                        <!-- Booking Form -->
                        <form action="{{ route('booking.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-5">
                                    <label class="block text-gray-300">Tanggal Booking</label>
                                    <input type="date" name="tanggal_booking" min="{{ date('Y-m-d') }}" required
                                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white">
                                </div>

                                <div class="space-y-5">
                                    <label class="block text-gray-300">Pilih Kendaraan</label>
                                    <select id="kendaraanDropdown" name="nopol" required class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white"
                                        @if(isset($kendaraanUser) && $kendaraanUser->isEmpty()) disabled @endif>
                                        <option value="">Pilih Kendaraan</option>
                                        @foreach($kendaraanUser as $kendaraan)
                                        @php
                                        $isBooked = \App\Models\Booking::where('nopol', $kendaraan->nopol)
                                        ->where('status', '!=', 'Selesai')->exists();
                                        @endphp
                                        <option value="{{ $kendaraan->nopol }}"
                                            data-merek="{{ $kendaraan->merek }}"
                                            data-tipe="{{ $kendaraan->tipe }}"
                                            data-transmisi="{{ $kendaraan->transmisi }}"
                                            data-kapasitas="{{ $kendaraan->kapasitas }}"
                                            data-tahun="{{ $kendaraan->tahun }}"
                                            @if($isBooked) disabled @endif>
                                            {{ $kendaraan->nopol }} - {{ $kendaraan->merek }} @if($isBooked) (Sudah Dibooking) @endif
                                        </option>
                                        @endforeach
                                    </select>

                                    @if(isset($kendaraanUser) && $kendaraanUser->isEmpty())
                                    <p class="text-red-500">User belum memiliki kendaraan</p>
                                    @endif

                                    <label class="block text-gray-300">Detail Kendaraan</label>
                                    <input type="text" name="merek" placeholder="Merek" readonly
                                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white">
                                    <input type="text" name="tipe" placeholder="Tipe" readonly
                                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white">
                                    <input type="number" name="tahun" placeholder="Tahun" readonly
                                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white">
                                    <input type="number" name="kapasitas" placeholder="Kapasitas (CC)" readonly
                                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white">
                                    <input type="text" name="transmisi" placeholder="Transmisi" readonly
                                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white">
                                </div>
                            </div>

                            <label class="block text-gray-300">Keluhan</label>
                            <textarea name="keluhan" placeholder="Masukkan keluhan (opsional)"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white"></textarea>

                            <button type="submit" class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl transition-all duration-300">
                                <i class="fas fa-check-circle"></i> Konfirmasi Booking
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const dropdown = document.getElementById("kendaraanDropdown");

                    dropdown.addEventListener("change", function() {
                        const selectedOption = dropdown.options[dropdown.selectedIndex];

                        document.querySelector("input[name='merek']").value = selectedOption.getAttribute("data-merek") || "";
                        document.querySelector("input[name='tipe']").value = selectedOption.getAttribute("data-tipe") || "";
                        document.querySelector("input[name='transmisi']").value = selectedOption.getAttribute("data-transmisi") || "";
                        document.querySelector("input[name='kapasitas']").value = selectedOption.getAttribute("data-kapasitas") || "";
                        document.querySelector("input[name='tahun']").value = selectedOption.getAttribute("data-tahun") || "";
                    });
                });
            </script>

            <!-- Main Content -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    @php
                    $kendaraan = \App\Models\Kendaraan::where('id_pelanggan', optional(Auth::user()->pelanggan)->ktp)->get();
                    @endphp

                    <!-- Tabel Kendaraan -->
                    <div class="lg:col-span-2 bg-gray-800/50 backdrop-blur-lg rounded-2xl p-6 border border-gray-700/50">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                            <i class="fas fa-motorcycle text-orange-400 mr-3"></i>
                            Kendaraan Saya
                        </h2>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-400">
                                <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">No. Polisi</th>
                                        <th scope="col" class="px-6 py-3">Merek</th>
                                        <th scope="col" class="px-6 py-3">Tipe</th>
                                        <th scope="col" class="px-6 py-3">Transmisi</th>
                                        <th scope="col" class="px-6 py-3">Kapasitas</th>
                                        <th scope="col" class="px-6 py-3">Tahun</th>
                                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kendaraan as $k)
                                    <tr class="border-b bg-gray-800 border-gray-700">
                                        <td class="px-6 py-4">{{ $k->nopol }}</td>
                                        <td class="px-6 py-4">{{ $k->merek }}</td>
                                        <td class="px-6 py-4">{{ $k->tipe }}</td>
                                        <td class="px-6 py-4 capitalize">{{ $k->transmisi }}</td>
                                        <td class="px-6 py-4">{{ $k->kapasitas }} cc</td>
                                        <td class="px-6 py-4">{{ $k->tahun }}</td>
                                        <td class="px-6 py-4 flex justify-center space-x-2">
                                            <a href="javascript:void(0)" onclick="openModal('{{ $k->nopol }}', '{{ $k->merek }}', '{{ $k->tipe }}', '{{ $k->transmisi }}', '{{ $k->kapasitas }}', '{{ $k->tahun }}')" class="text-blue-400 hover:text-blue-300 text-lg">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="/kendaraan/{{ $k->nopol }}" method="POST" onsubmit="return confirm('Hapus kendaraan ini?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300 text-lg">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 text-right">
                            <button onclick="openModal()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-400">
                                + Tambah Kendaraan
                            </button>
                        </div>
                    </div>

                    <!-- Modal Tambah/Edit Kendaraan -->
                    <div id="kendaraanModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
                        <div class="bg-gray-800 p-6 rounded-lg w-1/3">
                            <h2 id="modalTitle" class="text-white text-xl mb-4">Tambah Kendaraan</h2>
                            <form id="kendaraanForm" method="POST">
                                @csrf
                                <input type="hidden" name="_method" id="formMethod" value="POST">

                                <div class="mb-3">
                                    <label for="nopol" class="text-white">Nomor Polisi</label>
                                    <input type="text" name="nopol" id="nopol" class="w-full p-2 rounded bg-gray-700 text-white" required>
                                </div>
                                <div class="mb-3">
                                    <label for="merek" class="text-white">Merek</label>
                                    <input type="text" name="merek" id="merek" class="w-full p-2 rounded bg-gray-700 text-white" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tipe" class="text-white">Tipe</label>
                                    <input type="text" name="tipe" id="tipe" class="w-full p-2 rounded bg-gray-700 text-white" required>
                                </div>
                                <div class="mb-3">
                                    <label for="transmisi" class="text-white">Transmisi</label>
                                    <select name="transmisi" id="transmisi" class="w-full p-2 rounded bg-gray-700 text-white">
                                        <option value="manual">Manual</option>
                                        <option value="matic">Matic</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="kapasitas" class="text-white">Kapasitas (cc)</label>
                                    <input type="number" name="kapasitas" id="kapasitas" class="w-full p-2 rounded bg-gray-700 text-white" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tahun" class="text-white">Tahun</label>
                                    <input type="number" name="tahun" id="tahun" class="w-full p-2 rounded bg-gray-700 text-white" required>
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded" onclick="closeKendaraanModal()">Batal</button>
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Kendaraan User -->
                    <script>
                        function openModal(nopol = '', merek = '', tipe = '', transmisi = '', kapasitas = '', tahun = '') {
                            const modal = document.getElementById('kendaraanModal');
                            const form = document.getElementById('kendaraanForm');
                            const title = document.getElementById('modalTitle');
                            const methodInput = document.getElementById('formMethod');

                            if (nopol) {
                                // Jika Edit
                                title.innerText = 'Edit Kendaraan';
                                form.action = `/kendaraan/${nopol}`;
                                methodInput.value = 'PUT';

                                document.getElementById('nopol').value = nopol;
                                document.getElementById('merek').value = merek;
                                document.getElementById('tipe').value = tipe;
                                document.getElementById('transmisi').value = transmisi;
                                document.getElementById('kapasitas').value = kapasitas;
                                document.getElementById('tahun').value = tahun;
                            } else {
                                // Jika Tambah
                                title.innerText = 'Tambah Kendaraan';
                                form.action = `/kendaraan`;
                                methodInput.value = 'POST';

                                document.getElementById('nopol').value = '';
                                document.getElementById('merek').value = '';
                                document.getElementById('tipe').value = '';
                                document.getElementById('transmisi').value = 'manual';
                                document.getElementById('kapasitas').value = '';
                                document.getElementById('tahun').value = '';
                            }

                            modal.classList.remove('hidden');
                        }

                        function closeKendaraanModal() {
                            document.getElementById('kendaraanModal').classList.add('hidden');
                        }
                    </script>

                    <!-- Quick Actions -->
                    <div class="bg-gray-800/50 backdrop-blur-lg rounded-2xl p-6 border border-gray-700/50 h-fit">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                            <i class="fas fa-bolt text-blue-400 mr-3"></i>
                            Akses Cepat
                        </h2>

                        <div class="space-y-4">
                            <a href="#" onclick="openRiwayatModal(event)"
                                class="flex items-center p-4 bg-gray-700/40 hover:bg-gray-700/60 rounded-xl transition-all">
                                <div class="p-3 bg-blue-500/20 rounded-full mr-4">
                                    <i class="fas fa-history text-blue-400 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-white font-medium">Riwayat Servis</p>
                                    <p class="text-sm text-gray-400">Lihat semua servis sebelumnya</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- status Booking Kendaraan -->
                @php
                $bookingStatus = \App\Models\Booking::whereIn('nopol', $kendaraan->pluck('nopol'))
                ->orderByRaw("FIELD(status, 'Tunggu', 'Disetujui', 'Menunggu Antrian', 'Dikerjakan', 'Selesai', 'Sudah Dibayar', 'Dibatalkan')")
                ->get();
                @endphp

                <div class="mt-12 bg-gradient-to-r from-blue-600 to-purple-600 shadow-lg rounded-2xl p-8 border border-blue-500/50">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 mr-4 text-white text-4xl">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white">Status Booking Anda</h3>
                    </div>

                    @if ($bookingStatus->isEmpty())
                    <div class="flex items-center justify-center p-6 bg-gray-800/50 rounded-lg">
                        <p class="text-gray-300 text-lg flex items-center">
                            <i class="fas fa-check-circle text-green-400 text-2xl mr-2"></i> Semua kendaraan dalam kondisi baik!
                        </p>
                    </div>
                    @else

                    <div class="overflow-hidden border border-gray-700/50 rounded-lg shadow-md">
                        <table id="bookingTable" class="w-full text-sm text-left text-gray-300">
                            <thead class="text-xs uppercase bg-gray-900 text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Nomor Polisi</th>
                                    <th scope="col" class="px-10 py-4">Status</th>
                                    <th scope="col" class="px-6 py-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach ($bookingStatus as $booking)
                                <tr class="bg-gray-800 hover:bg-gray-700 transition"
                                    data-booking-id="{{ $booking->no_urut }}"
                                    data-tanggal-booking="{{ $booking->tanggal_booking }}"
                                    data-keluhan="{{ $booking->keluhan }}">
                                    <td class="px-6 py-4 font-semibold">{{ $booking->nopol }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-4 py-1 rounded-full text-white text-sm font-medium shadow-md"
                                            @class([ 'bg-yellow-500'=> $booking->status == 'Tunggu',
                                            'bg-blue-500' => $booking->status == 'Disetujui',
                                            'bg-purple-500' => $booking->status == 'Menunggu Antrian',
                                            'bg-orange-500' => $booking->status == 'Dikerjakan',
                                            'bg-green-500' => $booking->status == 'Selesai',
                                            'bg-teal-500' => $booking->status == 'Sudah Dibayar',
                                            'bg-red-500' => $booking->status == 'Dibatalkan',
                                            ])>
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            @if ($booking->status == 'Menunggu')
                                            <!-- Tombol untuk membuka modal -->
                                            <button onclick="openEditModal('{{ $booking->no_urut }}')"
                                                class="px-3 py-1 bg-blue-500 text-white text-sm rounded-lg shadow hover:bg-blue-600 transition">
                                                Edit
                                            </button>
                                            @endif
                                            @if ($booking->status === 'Menunggu')
                                            <form action="{{ route('booking.destroy', $booking->no_urut) }}" method="POST" onsubmit="return confirmDelete();">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-500 text-white text-sm rounded-lg shadow hover:bg-red-600 transition">
                                                    Cancel Booking
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <script>
                                    function confirmDelete() {
                                        return confirm('Yakin ingin menghapus booking ini?');
                                    }

                                    function confirmSuccess() {
                                        alert('Booking berhasil dihapus!');
                                    }

                                    function confirmError() {
                                        alert('Terjadi kesalahan saat menghapus booking!');
                                    }
                                </script>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>

                <!-- Modal Edit Booking -->
                <div id="editBookingModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center">
                    <div class="bg-gray-900 text-white p-6 rounded-lg shadow-lg w-96">
                        <h2 class="text-xl font-bold mb-4">Edit Booking</h2>

                        <form id="editBookingForm" method="POST">
                            @csrf
                            @method('PUT')

                            <input type="hidden" id="edit_no_urut" name="no_urut">

                            <div class="mb-4">
                                <label for="edit_tanggal_booking" class="block text-sm font-medium">Tanggal Booking</label>
                                <input type="date" id="edit_tanggal_booking" name="tanggal_booking"
                                    class="w-full p-2 bg-gray-800 border border-gray-600 rounded">
                            </div>

                            <div class="mb-4">
                                <label for="edit_keluhan" class="block text-sm font-medium">Keluhan</label>
                                <textarea id="edit_keluhan" name="keluhan"
                                    class="w-full p-2 bg-gray-800 border border-gray-600 rounded"></textarea>
                            </div>

                            <div class="flex space-x-2">
                                <button type="submit" class="px-4 py-2 bg-green-500 rounded hover:bg-green-600">Update</button>
                                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-500 rounded hover:bg-gray-600">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Riwayat -->
                <div id="riwayatModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4 transition-opacity duration-300">
                    <div class="bg-gray-800 text-gray-100 p-6 rounded-2xl shadow-2xl w-full max-w-7xl relative transform transition-transform duration-300 scale-95 opacity-0">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold text-blue-400">📋 Riwayat Servis</h3>
                            <button onclick="closeRiwayatModal()" class="p-2 hover:bg-gray-700 rounded-full transition-colors duration-200">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-gray-700">
                            <table class="w-full table-auto border-collapse">
                                <thead class="sticky top-0">
                                    <tr class="bg-gray-900 text-gray-300 text-sm font-semibold">
                                        <th class="p-4 text-left min-w-[120px]">Tanggal</th>
                                        <th class="p-4 text-left min-w-[200px]">Keluhan</th>
                                        <th class="p-4 text-left min-w-[200px]">Penanganan</th>
                                        <th class="p-4 text-left min-w-[180px]">Catatan</th>
                                        <th class="p-4 text-left min-w-[120px]">Karyawan</th>
                                        <th class="p-4 text-left min-w-[140px]">Kendaraan</th>
                                        <th class="p-4 text-left min-w-[150px]">Jasa Servis</th>
                                        <th class="p-4 text-right min-w-[120px]">Harga</th>
                                        <th class="p-4 text-left min-w-[200px]">Sparepart</th>
                                        <th class="p-4 text-right min-w-[100px]">Jumlah</th>
                                        <th class="p-4 text-right min-w-[140px]">Total</th>
                                        <th class="p-4 text-center min-w-[120px]">Status</th>
                                        <th class="p-4 min-w-[140px]">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700">
                                    @forelse($riwayat as $item)
                                    <tr class="hover:bg-gray-700/50 transition-colors duration-200">
                                        <td class="p-3 border border-gray-700">{{ $item->tanggal }}</td>
                                        <td class="p-3 border border-gray-700">{{ $item->keluhan }}</td>
                                        <td class="p-3 border border-gray-700">{{ $item->penanganan }}</td>
                                        <td class="p-3 border border-gray-700">{{ $item->catatan }}</td>
                                        <td class="p-3 border border-gray-700">{{ $item->karyawan->nama ?? '-' }}</td>
                                        <td class="p-3 border border-gray-700">
                                            @if(!empty($item->nopol))
                                            {{ $item->nopol }}
                                            @else
                                            <span class="text-yellow-400">Nopol tidak tersedia</span>
                                            @endif
                                        </td>

                                        <td class="p-3 border border-gray-700">{{ $item->jasaServis->jenis ?? '-' }}</td>
                                        <td class="p-3 border border-gray-700">
                                            Rp. {{ number_format($item->jasaServis->harga ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="p-3 border border-gray-700">
                                            @if($item->spareparts->isNotEmpty())
                                            @foreach($item->spareparts as $sparepart)
                                            {{ $sparepart->nama }} <br>
                                            @endforeach
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td class="p-3 border border-gray-700">
                                            @if($item->spareparts->isNotEmpty())
                                            @foreach($item->spareparts as $sparepart)
                                            {{ $sparepart->pivot->jumlah }} <br>
                                            @endforeach
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td class="p-3 border border-gray-700">
                                            Rp. {{ number_format($item->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td class="p-4 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($item->status == 'Selesai') bg-green-500/20 text-green-400
                                @elseif($item->status == 'Proses') bg-yellow-500/20 text-yellow-400
                                @else bg-green-500/20 text-white-400 @endif">
                                                @if($item->status == 'Selesai') ✓
                                                @elseif($item->status == 'Dibatalkan') ✗
                                                @else ✓ @endif
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-center">
                                            <!-- Button dengan Animasi -->
                                            <button class="invoice-btn px-6 py-3 bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-xl hover:from-purple-600 hover:to-blue-600 hover:scale-[1.02] hover:shadow-2xl hover:shadow-purple-500/30 transition-all duration-300 flex items-center gap-2 justify-center group relative overflow-hidden"
                                                data-id="{{ $item->id }}">
                                                <div class="absolute inset-0 bg-white/10 group-hover:bg-white/20 backdrop-blur-sm transition-colors duration-300"></div>
                                                <svg class="w-5 h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4V8H5v10h14M9 5h6v4h6v10h-2" />
                                                </svg>
                                                <span class="font-semibold tracking-wide relative">Invoice</span>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="13" class="p-6 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center space-y-2">
                                                <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>Tidak ada riwayat servis</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal dengan Efek Glassmorphism -->
                <div id="invoiceModal" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm flex justify-center items-center opacity-0 pointer-events-none transition-all duration-300">
                    <div class="bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-2xl w-11/12 max-w-4xl transform scale-95 transition-transform duration-300 border border-white/20 relative">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-purple-500/10 to-blue-500/10"></div>
                        <div class="relative">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-500 bg-clip-text text-transparent">
                                    Invoice Servis
                                </h2>
                                <button onclick="closeModal()" class="text-gray-600 hover:text-purple-600 transition-colors duration-200 text-3xl p-2 hover:rotate-90 transition-transform">
                                    &times;
                                </button>
                            </div>
                            <div id="invoiceContent" class="overflow-y-auto max-h-[70vh]">
                                <!-- Isi invoice akan dimuat di sini -->
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    // Modal functions with animations
                    function openRiwayatModal(event) {
                        event.preventDefault();
                        const modal = document.getElementById('riwayatModal');
                        const modalContent = modal.querySelector('div');
                        modal.classList.remove('hidden');
                        setTimeout(() => {
                            modalContent.classList.remove('scale-95', 'opacity-0');
                            modalContent.classList.add('scale-100', 'opacity-100');
                        }, 10);
                    }

                    function closeRiwayatModal() {
                        const modal = document.getElementById('riwayatModal');
                        const modalContent = modal.querySelector('div');
                        modalContent.classList.remove('scale-100', 'opacity-100');
                        modalContent.classList.add('scale-95', 'opacity-0');
                        setTimeout(() => {
                            modal.classList.add('hidden');
                        }, 300);
                    }

                    document.addEventListener("DOMContentLoaded", function() {
                        document.querySelectorAll(".invoice-btn").forEach(button => {
                            button.addEventListener("click", function() {
                                let id = this.getAttribute("data-id");
                                showInvoice(id);
                            });
                        });
                    });

                    function showInvoice(id) {
                        fetch(`/invoice/${id}`)
                            .then(response => response.text())
                            .then(data => {
                                document.getElementById('invoiceContent').innerHTML = data;
                                const modal = document.getElementById('invoiceModal');
                                const modalContent = modal.querySelector('div > div');

                                modal.classList.remove('opacity-0', 'pointer-events-none');
                                modal.classList.add('opacity-100', 'pointer-events-auto');

                                modalContent.classList.remove('scale-95');
                                modalContent.classList.add('scale-100');

                                // Tambah animasi masuk konten
                                Array.from(document.getElementById('invoiceContent').children).forEach((child, index) => {
                                    child.style.opacity = '0';
                                    setTimeout(() => {
                                        child.style.transition = 'all 0.3s ease-out';
                                        child.style.opacity = '1';
                                    }, index * 50);
                                });
                            })
                            .catch(error => console.error('Error:', error));
                    }

                    function closeModal() {
                        const modal = document.getElementById('invoiceModal');
                        const modalContent = modal.querySelector('div > div');

                        modal.classList.remove('opacity-100', 'pointer-events-auto');
                        modal.classList.add('opacity-0', 'pointer-events-none');

                        modalContent.classList.remove('scale-100');
                        modalContent.classList.add('scale-95');
                    }

                    function addOutsideClickClose(modalId, closeFunction) {
                        const modal = document.getElementById(modalId);
                        modal.addEventListener('click', function(event) {
                            if (event.target === modal) {
                                closeFunction();
                            }
                        });
                    }

                    // Contoh penggunaan:
                    addOutsideClickClose('invoiceModal', closeModal);
                    addOutsideClickClose('riwayatModal', closeRiwayatModal);

                    function openEditModal(no_urut) {
                        // Ambil data dari tabel booking
                        let bookingRow = document.querySelector(`[data-booking-id="${no_urut}"]`);
                        let tanggalBooking = bookingRow.getAttribute("data-tanggal-booking");
                        let keluhan = bookingRow.getAttribute("data-keluhan");

                        // Set nilai input dalam modal
                        document.getElementById("edit_no_urut").value = no_urut;
                        document.getElementById("edit_tanggal_booking").value = tanggalBooking;
                        document.getElementById("edit_keluhan").value = keluhan;

                        // Set action form untuk update
                        document.getElementById("editBookingForm").action = `/booking/${no_urut}`;

                        // Tampilkan modal
                        document.getElementById("editBookingModal").classList.remove("hidden");
                    }

                    function closeEditModal() {
                        document.getElementById("editBookingModal").classList.add("hidden");
                    }
                </script>

                <!-- Maintenance Tips -->
                <div class="mt-12 bg-gradient-to-r from-orange-500/10 to-transparent rounded-2xl p-8 border border-orange-500/30"
                    x-data="{ currentTip: 0, tips: [
                    'Servis rutin setiap 4000 km untuk performa optimal',
                    'Periksa tekanan angin ban setiap 2 minggu sekali',
                    'Ganti oli mesin sesuai rekomendasi pabrikan',
                    'Bersihkan rantai secara berkala'
                 ] }"
                    x-init="setInterval(() => currentTip = (currentTip + 1) % tips.length, 7000)">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-6 text-orange-400 text-3xl">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-2">Tips Perawatan Motor</h3>
                            <div class="text-gray-300 italic"
                                x-text="tips[currentTip]"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>