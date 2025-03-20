@php
$pelanggan = App\Models\Pelanggan::all();
$kendaraan = App\Models\Kendaraan::all();
@endphp
<x-app-layout>
    <style>
        .compact-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .compact-table th,
        .compact-table td {
            border-right: 1px solid #374151;
            border-bottom: 1px solid #374151;
        }

        .compact-table th:last-child,
        .compact-table td:last-child {
            border-right: 0;
        }
    </style>
    <!-- Main Content -->
    <main class="bg-gray-900 min-h-screen">
        <!-- Management Quick Access -->
        <div class="max-w-1xl mx-12 px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Pelanggan Card -->
                <a href="{{ route('admin.pelanggan.index') }}"
                    class="bg-gray-800 rounded-2xl p-6 transform transition-all hover:scale-105 hover:shadow-2xl group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-700 p-4 rounded-xl group-hover:bg-gray-600 transition-colors">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">Kelola Pelanggan</h3>
                            <p class="text-gray-400 mt-1 text-sm">Total {{ $pelanggan->count() }} pelanggan</p>
                        </div>
                    </div>
                </a>

                <!-- Kendaraan Card -->
                <a href="{{ route('admin.kendaraan.index') }}"
                    class="bg-gray-800 rounded-2xl p-6 transform transition-all hover:scale-105 hover:shadow-2xl group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-700 p-4 rounded-xl group-hover:bg-gray-600 transition-colors">
                            <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">Kelola Kendaraan</h3>
                            <p class="text-gray-400 mt-1 text-sm">Total {{ $kendaraan->count() }} kendaraan</p>
                        </div>
                    </div>
                </a>

                <!-- Sparepart Card -->
                <a href="{{ route('admin.sparepart.index') }}"
                    class="bg-gray-800 rounded-2xl p-6 transform transition-all hover:scale-105 hover:shadow-2xl group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-700 p-4 rounded-xl group-hover:bg-gray-600 transition-colors">
                            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1m-2 1l2-1m0 2.5V4m0 16.5v-2.5M6 7l-2 1m2-1L4 6m2 1v2.5" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">Kelola Sparepart</h3>
                            <p class="text-gray-400 mt-1 text-sm">Total {{ $totalSparepart }} item tersedia</p>
                        </div>
                    </div>
                </a>

                <!-- Users Card -->
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-800 rounded-2xl p-6 transform transition-all hover:scale-105 hover:shadow-2xl group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-700 p-4 rounded-xl group-hover:bg-gray-600 transition-colors">
                            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">Kelola Users</h3>
                            <p class="text-gray-400 mt-1 text-sm">Admin & staff</p>
                        </div>
                    </div>
                </a>

                <!-- Jasa Servis Card -->
                <a href="{{ route('admin.jasa_servis.index') }}"
                    class="bg-gray-800 rounded-2xl p-6 transform transition-all hover:scale-105 hover:shadow-2xl group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-700 p-4 rounded-xl group-hover:bg-gray-600 transition-colors">
                            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">Kelola Jasa Servis</h3>
                            <p class="text-gray-400 mt-1 text-sm">Servis Motor</p>
                        </div>
                    </div>
                </a>

                <!-- Booking Card -->
                <a href="{{ route('admin.booking.index') }}"
                    class="bg-gray-800 rounded-2xl p-6 transform transition-all hover:scale-105 hover:shadow-2xl group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-700 p-4 rounded-xl group-hover:bg-gray-600 transition-colors">
                            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">Booking</h3>
                            <p class="text-gray-400 mt-1 text-sm">Antrian Booking</p>
                        </div>
                    </div>
                </a>

                <!-- Riwayat -->
                <a href="{{ route('admin.riwayat.index') }}"
                    class="bg-gray-800 rounded-2xl p-6 transform transition-all hover:scale-105 hover:shadow-2xl group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-700 p-4 rounded-xl group-hover:bg-gray-600 transition-colors">
                            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">Riwayat</h3>
                            <p class="text-gray-400 mt-1 text-sm">Cek dan edit riwayat</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                <!-- Pelanggan Stat -->
                <div class="bg-gray-800 rounded-2xl p-6 transform transition-all hover:scale-[1.02]">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-400">Total User</p>
                            <p class="text-3xl font-bold text-white mt-2">{{ $pelanggan->count() }}</p>
                        </div>
                        <div class="animate-pulse">
                            <div class="h-12 w-12 bg-blue-500/20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 h-1 bg-gray-700 rounded-full">
                        <div class="h-1 bg-blue-500 rounded-full w-3/4"></div>
                    </div>
                </div>

                <!-- Kendaraan Stat -->
                <div class="bg-gray-800 rounded-2xl p-6 transform transition-all hover:scale-[1.02]">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-400">Total Kendaraan</p>
                            <p class="text-3xl font-bold text-white mt-2">{{ $kendaraan->count() }}</p>
                        </div>
                        <div class="animate-pulse">
                            <div class="h-12 w-12 bg-purple-500/20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 h-1 bg-gray-700 rounded-full">
                        <div class="h-1 bg-purple-500 rounded-full w-2/3"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Penghasilan Bulanan -->
        <div class="mx-20 bg-gray-800 rounded-xl shadow-lg p-6 transform transition-all">
            <div class="p-5 border-b border-gray-700 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-200">Total Penghasilan</h2>
                <select id="filter-bulan" class="bg-gray-700 text-white p-2 rounded-lg text-sm">
                    @foreach(range(1, 12) as $bulan)
                    @php
                    $bulanFormat = str_pad($bulan, 2, '0', STR_PAD_LEFT);
                    $selected = request('bulan') == $bulanFormat ? 'selected' : '';
                    @endphp
                    <option value="{{ $bulanFormat }}" {{ $selected }}>
                        {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full compact-table">
                    <thead class="bg-gray-750 sticky top-0">
                        <tr class="text-xs font-semibold text-gray-400 uppercase tracking-wide">
                            <th class="px-3 py-3 text-left text-gray-300">Bulan</th>
                            <th class="px-3 py-3 text-left text-gray-300">Total Penghasilan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700 text-sm">
                        <tr class="hover:bg-gray-750 transition-colors">
                            <td class="px-3 py-3 text-white">{{ date('F', mktime(0, 0, 0, request('bulan', date('m')), 1)) }}</td>
                            <td class="px-3 py-3 text-white">Rp {{ number_format($totalPenghasilan, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br><br>

        <script>
            document.getElementById('filter-bulan').addEventListener('change', function() {
                let url = new URL(window.location.href);
                url.searchParams.set('bulan', this.value);
                window.location.href = url.toString();
            });
        </script>

        <!-- Daftar Booking -->
        <div class="mx-20 bg-gray-800 rounded-xl shadow-lg p-6 transform transition-all">
            <div class="p-5 border-b border-gray-700">
                <h2 class="text-lg font-semibold text-gray-200">Daftar Booking</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full compact-table">
                    <thead class="bg-gray-750 sticky top-0">
                        <tr class="text-xs font-semibold text-gray-400 uppercase tracking-wide">
                            <th class="px-3 py-3 text-left text-gray-300 sticky left-0 bg-gray-750">No. Antrian</th>
                            <th class="px-3 py-3 text-left text-gray-300">Nomor Polisi</th>
                            <th class="px-3 py-3 text-left text-gray-300">Merek</th>
                            <th class="px-3 py-3 text-left text-gray-300">Tipe</th>
                            <th class="px-3 py-3 text-left text-gray-300">Tanggal</th>
                            <th class="px-3 py-3 text-left text-gray-300 max-w-[120px]">Keluhan</th>
                            <th class="px-3 py-3 text-left text-gray-300">Status</th>
                            <th class="px-3 py-3 text-left text-gray-300">Penanganan</th>
                            <th class="px-3 py-3 text-left text-gray-300">Catatan</th>
                            <th class="px-3 py-3 text-left text-gray-300">Jasa Servis</th>
                            <th class="px-3 py-3 text-left text-gray-300">Sparepart</th>
                            <th class="px-3 py-3 text-left text-gray-300">Waktu Datang</th>
                            <th class="px-3 py-3 text-left text-gray-300">Aksi</th>
                            <th class="px-3 py-3 text-center text-gray-300">Status</th>
                            <th class="px-3 py-3 text-center text-gray-300">Karyawan</th>
                            <th class="px-3 py-3 text-center text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700 text-sm">
                        @foreach($bookings as $booking)
                        <tr class="hover:bg-gray-750 transition-colors group">
                            <td class="px-3 py-2 text-xs font-medium sticky left-0 bg-gray-800 group-hover:bg-gray-750 text-white">{{ $booking->no_antrian_per_hari }}</td>
                            <td class="px-3 py-3 text-white">{{ $booking->nopol }}</td>
                            <td class="px-3 py-3 text-white">{{ $booking->merek }}</td>
                            <td class="px-3 py-3 text-white">{{ $booking->tipe }}</td>
                            <td class="px-3 py-3 text-white whitespace-nowrap">{{ $booking->tanggal_booking }}</td>
                            <td class="px-3 py-3 text-white max-w-[120px] truncate">{{ $booking->keluhan }}</td>
                            <td class="px-3 py-3 text-white">{{ $booking->status }}</td>

                            <!-- Ambil Data dari Riwayat dan Jasa Servis -->
                            @php
                            $riwayat = $riwayats->where('nopol', $booking->nopol)->first();
                            $jasaServis = $riwayat ? $jasa_servis->where('id', $riwayat->id_jasa)->first() : null;
                            @endphp

                            <td class="px-3 py-2">
                                <input type="text" id="penanganan-{{ $booking->no_urut }}"
                                    class="w-32 bg-gray-700 border border-gray-600 text-xs text-white p-1.5 rounded-md focus:ring-1 focus:ring-blue-500"
                                    placeholder="Masukkan penanganan">
                            </td>

                            <td class="px-3 py-2">
                                <input type="text" id="catatan-{{ $booking->no_urut }}"
                                    class="w-32 bg-gray-700 border border-gray-600 text-xs text-white p-1.5 rounded-md focus:ring-1 focus:ring-blue-500"
                                    placeholder="Masukkan catatan">
                            </td>

                            <td class="p-4">
                                <select class="bg-gray-700 text-white p-2 rounded-lg text-sm" id="jasa-{{ $booking->no_urut }}">
                                    <option value="">Pilih Jasa Servis</option>
                                    @foreach($jasa_servis as $jasa)
                                    <option value="{{ $jasa->id }}">{{ $jasa->jenis }} - Rp{{ number_format($jasa->harga, 0, ',', '.') }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td class="p-4 text-white">
                                @foreach($spareparts as $sparepart)
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="sparepart-{{ $booking->no_urut }}-{{ $sparepart->kode }}"
                                        name="sparepart[]"
                                        value="{{ $sparepart->kode }}"
                                        class="sparepart-checkbox"
                                        data-booking="{{ $booking->no_urut }}"
                                        data-kode="{{ $sparepart->kode }}">
                                    <label for="sparepart-{{ $booking->no_urut }}-{{ $sparepart->kode }}">
                                        {{ $sparepart->nama }} ({{ $sparepart->jumlah }} stok)
                                    </label>
                                    <input type="number" id="jumlah-{{ $booking->no_urut }}-{{ $sparepart->kode }}"
                                        class="jumlah-input hidden bg-gray-700 text-white p-1 rounded w-16"
                                        placeholder="Jumlah" min="1" max="{{ $sparepart->jumlah }}">
                                </div>
                                @endforeach
                            </td>

                            </td>

                            <td class="p-4">
                                <input type="datetime-local" id="waktu-datang-{{ $booking->no_urut }}"
                                    class="bg-gray-700 text-white p-2 rounded-lg text-sm"
                                    value="{{ $booking->waktu_datang ?? '' }}"
                                    {{ $booking->status === 'Disetujui' ? '' : 'disabled' }}>
                            </td>

                            <td class="p-4">
                                <button id="simpan-{{ $booking->no_urut }}"
                                    class="bg-blue-500 text-white px-3 py-2 rounded-lg text-sm hidden"
                                    data-id="{{ $booking->no_urut }}">
                                    Simpan
                                </button>
                            </td>

                            <td class="p-4">
                                <select id="status-{{ $booking->no_urut }}"
                                    class="bg-gray-700 text-white p-2 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 border-none"
                                    data-id="{{ $booking->no_urut }}"
                                    onchange="updateStatus(this)">
                                    <option value="Tunggu" {{ $booking->status == 'Tunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Disetujui" {{ $booking->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="Menunggu Antrian" {{ $booking->status == 'Menunggu Antrian' ? 'selected' : '' }}>Menunggu Antrian</option>
                                    <option value="Dikerjakan" {{ $booking->status == 'Dikerjakan' ? 'selected' : '' }}>Dikerjakan</option>
                                    <option value="Selesai" {{ $booking->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="Sudah Dibayar" {{ $booking->status == 'Sudah Dibayar' ? 'selected' : '' }}>Sudah Dibayar</option>
                                    <option value="Dibatalkan" {{ $booking->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </td>

                            <td class="p-4">
                                <select class="bg-gray-700 text-white p-2 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 border-none"
                                    data-id="{{ $booking->no_urut }}" id="karyawan-{{ $booking->no_urut }}">
                                    <option value="">Pilih Karyawan</option>
                                    @foreach($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-4 text-center">
                                <button class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-lg text-white transition-colors konfirmasi-btn"
                                    data-id="{{ $booking->no_urut }}">
                                    Konfirmasi
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br><br>

        <script>
            // booking status
            document.querySelectorAll('[id^="status-"]').forEach(select => {
                select.addEventListener('change', function() {
                    let bookingId = this.dataset.id;
                    let waktuDatangInput = document.getElementById(`waktu-datang-${bookingId}`);
                    let simpanButton = document.getElementById(`simpan-${bookingId}`);

                    if (this.value === "Disetujui") {
                        waktuDatangInput.removeAttribute("disabled"); // Aktifkan input waktu
                        simpanButton.classList.remove("hidden"); // Tampilkan tombol Simpan
                    } else {
                        waktuDatangInput.setAttribute("disabled", "true"); // Nonaktifkan input waktu
                        simpanButton.classList.add("hidden"); // Sembunyikan tombol Simpan
                    }
                });
            });

            document.querySelectorAll('[id^="simpan-"]').forEach(button => {
                button.addEventListener('click', function() {
                    let bookingId = this.dataset.id;
                    let waktuDatangInput = document.getElementById(`waktu-datang-${bookingId}`);
                    let waktuDatang = waktuDatangInput.value;

                    if (!waktuDatang) {
                        alert("Harap isi waktu datang sebelum menyimpan.");
                        return;
                    }

                    fetch(`/booking-karyawan/update-status/${bookingId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                status: "Disetujui",
                                waktu_datang: waktuDatang
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                            location.reload(); // Refresh untuk update tampilan
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            function toggleInput(bookingId) {
                let statusSelect = document.getElementById(`status-${bookingId}`);
                let waktuDatangInput = document.getElementById(`waktu-datang-${bookingId}`);
                let simpanButton = document.getElementById(`simpan-${bookingId}`);

                if (statusSelect.value === "Disetujui") {
                    waktuDatangInput.removeAttribute("disabled");
                    simpanButton.classList.remove("hidden"); // Tampilkan tombol simpan
                } else {
                    waktuDatangInput.setAttribute("disabled", "true");
                    simpanButton.classList.add("hidden"); // Sembunyikan tombol simpan
                }
            }

            function konfirmasiWaktu(bookingId) {
                console.log("Booking ID:", bookingId); // Debugging

                let waktuDatangInput = document.getElementById(`waktu-datang-${bookingId}`);
                let statusSelect = document.getElementById(`status-${bookingId}`);

                let waktuDatang = waktuDatangInput.value;
                let status = statusSelect.value;

                if (!waktuDatang) {
                    alert("Silakan isi waktu datang sebelum menyetujui.");
                    return;
                }

                let dataToSend = {
                    status: status,
                    waktu_datang: waktuDatang
                };

                fetch(`/booking-karyawan/update-status/${bookingId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(dataToSend)
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        location.reload();
                    })
                    .catch(error => console.error('Error:', error));
            }

            function updateStatus(select) {
                const bookingId = select.dataset.id; // Ambil ID booking
                const newStatus = select.value; // Ambil status yang dipilih
                const waktuDatangInput = document.getElementById(`waktu-datang-${bookingId}`);
                const waktuDatang = waktuDatangInput ? waktuDatangInput.value : null;

                let dataToSend = {
                    status: newStatus
                };

                // Jika status "Disetujui", kirim juga waktu datang
                if (newStatus === "Disetujui") {
                    if (!waktuDatang) {
                        alert("Silakan isi waktu datang sebelum menyetujui.");
                        return;
                    }
                    dataToSend.waktu_datang = waktuDatang;
                }

                fetch(`/booking-karyawan/update-status/${bookingId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(dataToSend)
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        location.reload();
                    })
                    .catch(error => console.error('Error:', error));
            }

            function submitInput() {
                const bookingId = document.getElementById('bookingId').value;
                const inputData = document.getElementById('inputField').value;
                const label = document.getElementById('inputLabel').innerText;

                let data = {
                    status: document.querySelector(`select[data-id="${bookingId}"]`).value
                };

                if (label.includes("Waktu Datang")) {
                    data.waktu_datang = inputData;
                } else if (label.includes("Penanganan & Catatan")) {
                    let [penanganan, catatan] = inputData.split(";");
                    data.penanganan = penanganan.trim();
                    data.catatan = catatan.trim();
                }

                sendUpdate(bookingId, data.status, data);
                closeModal();
            }

            function closeModal() {
                document.getElementById('inputModal').classList.add('hidden');
            }

            function sendUpdate(bookingId, status, extraData) {
                let bodyData = {
                    status
                };
                if (extraData) Object.assign(bodyData, extraData);

                fetch(`/booking-karyawan/update-status/${bookingId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(bodyData)
                    })
                    .then(response => response.json())
                    .then(data => alert(data.message));
            }

            document.querySelectorAll('.sparepart-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    let bookingId = this.dataset.booking;
                    let kode = this.dataset.kode;
                    let jumlahInput = document.getElementById(`jumlah-${bookingId}-${kode}`);

                    if (this.checked) {
                        jumlahInput.classList.remove('hidden');
                        jumlahInput.required = true;
                    } else {
                        jumlahInput.classList.add('hidden');
                        jumlahInput.value = "";
                        jumlahInput.required = false;
                    }
                });
            });

            function getSelectedSpareparts(bookingId) {
                let spareparts = [];
                document.querySelectorAll(`.sparepart-checkbox[data-booking="${bookingId}"]:checked`).forEach(checkbox => {
                    let kode = checkbox.value;
                    let jumlah = document.getElementById(`jumlah-${bookingId}-${kode}`).value;

                    if (!jumlah || jumlah <= 0) {
                        alert(`Jumlah untuk ${kode} harus diisi dengan benar!`);
                        return;
                    }

                    spareparts.push({
                        kode_sparepart: kode,
                        jumlah: jumlah
                    });
                });
                return spareparts;
            }

            function kirimKeRiwayat(button) {
                const bookingId = button.dataset.id;
                const spareparts = getSelectedSpareparts(bookingId);
                const penanganan = document.getElementById(`penanganan-${bookingId}`).value;
                const catatan = document.getElementById(`catatan-${bookingId}`).value;
                const karyawanId = document.getElementById(`karyawan-${bookingId}`).value;
                const jasaId = document.getElementById(`jasa-${bookingId}`).value;

                if (!penanganan || !catatan) {
                    alert('Penanganan dan catatan harus diisi.');
                    return;
                }

                if (spareparts.length === 0) {
                    alert('Pilih minimal satu sparepart dengan jumlah yang valid.');
                    return;
                }

                fetch(`/booking-karyawan/kirim-ke-riwayat/${bookingId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            penanganan,
                            catatan,
                            spareparts, // Kirim sebagai array objek [{ kode_sparepart: "SP001", jumlah: 2 }, ...]
                            id_karyawan: karyawanId,
                            id_jasa: jasaId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        location.reload();
                    })
                    .catch(error => console.error('Error:', error));
            }

            document.querySelectorAll('.konfirmasi-btn').forEach(button => {
                button.addEventListener('click', function() {
                    kirimKeRiwayat(this);
                });
            });

            // tampilan alert
            fetch('/your-api-endpoint', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        /* Data yang dikirim */
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message); // Alert standar
                })
                .catch(error => console.error('Error:', error));
        </script>

        <!-- Recent Activity -->
        <div class="max-w-1xl mx-12 px-4 sm:px-6 lg:px-8 pb-12">
            <div class="bg-gray-800 rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6">Aktivitas Login</h3>
                <div class="space-y-6">
                    @foreach ($aktivitasTerkini as $aktivitas)
                    <div class="flex items-center justify-between p-4 bg-gray-700/50 rounded-xl hover:bg-gray-700 transition-colors">
                        <div class="flex items-center space-x-4">
                            <div class="bg-blue-500/20 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-medium">{{ $aktivitas->deskripsi }}</p>
                                <p class="text-gray-400 text-sm">{{ $aktivitas->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- More activity items... -->
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 border-t border-gray-700">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-400 text-sm">&copy; {{ date('Y') }} Admin Dashboard. All rights reserved.</p>
        </div>
    </footer>
</x-app-layout>