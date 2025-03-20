<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abakura Racing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    @once
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @endonce

    <!-- swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Required Dependencies -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @once
    <script src="{{ asset('js/script.js') }}"></script>
    @endonce

    <!-- check status login -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/check-auth')
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(data => {
                    window.authStatus = data.authenticated;
                })
                .catch(error => {
                    console.error('Auth check failed:', error);
                    window.authStatus = false;
                });
        });
    </script>

</head>

<body class="test bg-gray-900">
    <!-- Header -->
    <header class="bg-gray-800 shadow-xl fixed w-full z-50 animate-slide-down">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <h1 class="text-2xl font-bold text-gray-300">Abakura<span class="text-red-600">Racing</span></h1>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    @auth
                    <a href="{{ Auth::user()->role === 'admin' ? url('/admin/admindashboard') : url('/dashboard') }}"
                        class="px-3 py-2 text-gray-300 hover:text-red-500 transition-colors duration-300">
                        Dashboard <i class="ml-1 fas fa-arrow-right"></i>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="px-3 py-2 text-gray-300 hover:text-red-500 transition-colors duration-300">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300 transform hover:scale-105">
                        Register
                    </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <body x-data="{ open: false }">

        <!-- Hero Section -->
        <div class="pt-16 animate-fade-in">

            <div class="relative h-[600px] bg-cover bg-center overflow-hidden group">
                <img src="{{ asset('img/bg.jpg') }}" alt="Background Image" loading=lazy
                    class="absolute inset-0 w-full h-full object-cover transform transition-all duration-1000 group-hover:scale-110">

                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-gray-900/70 to-black/80 
                    transition-all duration-500 group-hover:backdrop-blur-xl"></div>

                <!-- Konten -->
                <div class="relative h-full flex items-center justify-center z-10">
                    <div class="text-center text-white px-4 space-y-8">
                        <h2 class="text-5xl font-bold mb-6 transition-all duration-500 transform group-hover:scale-105">
                            <span class="relative inline-block">
                                <span class="absolute inset-0 bg-red-600/30 blur-3xl group-hover:opacity-100 
                                  opacity-0 transition-opacity duration-300"></span>
                                <span class="text-red-600 relative text-stroke 
                                  transition-all duration-500 hover:animate-text-glow
                                  bg-clip-text bg-gradient-to-r from-red-400 to-red-600
                                  hover:text-transparent">
                                    Abakura
                                </span>
                            </span>
                            <span class="text-white ml-4 relative
                              bg-clip-text bg-gradient-to-r from-gray-100 to-gray-300
                              text-stroke transition-all duration-500
                              group-hover:text-transparent group-hover:drop-shadow-[0_0_15px_rgba(239,68,68,0.8)]">
                                Racing
                            </span>
                        </h2>

                        <p class="text-xl mb-8 text-gray-300 max-w-2xl mx-auto transform transition-all duration-500
                         translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100
                         backdrop-blur-sm px-4 py-2 rounded-lg">
                            Redi Garap Bahan Jengatmu maseeeeeeeeeeeeeeeee.
                        </p>

                        <button
                            @click="authStatus ? open = true : document.getElementById('loginRequiredModal').style.display = 'flex'"
                            class="relative overflow-hidden bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white px-8 py-4 rounded-2xl
           text-xl transition-all duration-500 transform hover:scale-105 shadow-2xl
           before:absolute before:inset-0 before:bg-gradient-to-r before:from-white/20 before:to-transparent
           before:opacity-0 hover:before:opacity-100 before:transition-opacity before:duration-500
           hover:shadow-red-500/30 text-center inline-block">
                            <span class="relative z-10 flex items-center justify-center space-x-3">
                                <span>Booking Sekarang</span>
                                <i class="fas fa-calendar-check animate-pulse"></i>
                            </span>
                        </button>
                        <br>

                        <!-- Tombol Periksa Antrian (Hanya untuk User yang Sudah Login) -->
                        <button onclick="openAntrianModal()"
                            class="relative overflow-hidden bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white px-8 py-4 rounded-2xl
               text-xl transition-all duration-500 transform hover:scale-105 shadow-2xl
               before:absolute before:inset-0 before:bg-gradient-to-r before:from-white/20 before:to-transparent
               before:opacity-0 hover:before:opacity-100 before:transition-opacity before:duration-500
               hover:shadow-blue-500/30 text-center inline-block">
                            <span class="relative z-10 flex items-center justify-center space-x-3">
                                <span>Periksa Antrian</span>
                                <i class="fas fa-list-check animate-pulse"></i>
                            </span>
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Periksa Antrian -->
        <div id="antrianModal" class="fixed inset-0 backdrop-blur-sm bg-black/30 flex items-center justify-center p-4 opacity-0 invisible transition-all duration-300 z-[999]">
            <div class="bg-gray-800/95 border border-white/10 backdrop-blur-xl rounded-xl shadow-2xl w-full max-w-4xl transform transition-all duration-300 scale-95 origin-center">
                <!-- Header -->
                <div class="p-6 border-b border-white/10 flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                            🚘 Daftar Antrian Servis
                        </h2>
                        <p class="text-sm text-gray-400 mt-1">Lihat status antrian servis kendaraan Anda</p>
                    </div>
                    <button onclick="closeAntrianModal()" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6 space-y-6">
                    <!-- Filter -->
                    <div class="flex gap-4 items-center">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Pilih Tanggal</label>
                            <input type="date" id="filterTanggal"
                                class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 focus:border-blue-400/50 focus:ring-2 focus:ring-blue-400/20 text-white placeholder-gray-400 transition-all outline-none">
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="border border-white/10 rounded-xl overflow-hidden">
                        <div class="relative max-h-[60vh] overflow-y-auto">
                            <table class="w-full text-sm">
                                <thead class="sticky top-0 bg-gradient-to-b from-gray-800 to-gray-800/80 backdrop-blur-sm z-10">
                                    <tr class="text-gray-300 border-b border-white/10">
                                        <th class="px-6 py-4 font-semibold text-left">No. Antrian</th>
                                        <th class="px-6 py-4 font-semibold text-left">Nomor Polisi</th>
                                        <th class="px-6 py-4 font-semibold text-left">Merek</th>
                                        <th class="px-6 py-4 font-semibold text-left">Tipe</th>
                                        <th class="px-6 py-4 font-semibold text-left">Tanggal</th>
                                        <th class="px-6 py-4 font-semibold text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5 text-white" id="antrianTable">
                                    <!-- Skeleton Loading -->
                                    <tr class="animate-pulse">
                                        <td class="px-6 py-4 text-white">
                                            <div class="h-4 bg-gray-700 rounded"></div>
                                        </td>
                                        <td class="px-6 py-4 text-white">
                                            <div class="h-4 bg-gray-700 rounded"></div>
                                        </td>
                                        <td class="px-6 py-4 text-white">
                                            <div class="h-4 bg-gray-700 rounded"></div>
                                        </td>
                                        <td class="px-6 py-4 text-white">
                                            <div class="h-4 bg-gray-700 rounded"></div>
                                        </td>
                                        <td class="px-6 py-4 text-white">
                                            <div class="h-4 bg-gray-700 rounded"></div>
                                        </td>
                                        <td class="px-6 py-4 text-white">
                                            <div class="h-4 bg-gray-700 rounded w-3/4"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-4 border-t border-white/10 flex justify-end gap-2">
                    <button onclick="closeAntrianModal()"
                        class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-blue-400/20 to-purple-400/20 border border-blue-400/30 hover:border-blue-400/50 text-blue-300 hover:text-white transition-all font-medium flex items-center gap-2">
                        Tutup Panel
                    </button>
                </div>
            </div>
        </div>

        <script>
            function openAntrianModal() {
                let modal = document.getElementById('antrianModal');
                modal.classList.add('active'); // Tambahkan kelas "active" agar modal muncul
                modal.classList.remove('opacity-0', 'invisible'); // Pastikan modal terlihat
                modal.firstElementChild.classList.remove('scale-95'); // Efek zoom in modal
                modal.firstElementChild.classList.add('scale-100');
                loadAntrian();
            }

            function closeAntrianModal() {
                let modal = document.getElementById('antrianModal');
                modal.classList.remove('active');
                modal.classList.add('opacity-0', 'invisible'); // Sembunyikan modal
                modal.firstElementChild.classList.remove('scale-100');
                modal.firstElementChild.classList.add('scale-95');
            }

            function loadAntrian() {
                let tanggal = document.getElementById('filterTanggal').value;
                fetch(`/get-antrian?tanggal=${tanggal}`)
                    .then(response => response.json())
                    .then(data => {
                        let tableBody = document.getElementById('antrianTable');
                        tableBody.innerHTML = '';
                        data.forEach(booking => {
                            let row = `<tr class="border-b bg-gray-800 border-gray-700">
                        <td class="px-6 py-4">${booking.no_antrian_per_hari}</td>
                        <td class="px-6 py-4">${booking.nopol}</td>
                        <td class="px-6 py-4">${booking.merek}</td>
                        <td class="px-6 py-4">${booking.tipe}</td>
                        <td class="px-6 py-4">${booking.tanggal_booking}</td>
                        <td class="px-6 py-4">${booking.status}</td>
                    </tr>`;
                            tableBody.innerHTML += row;
                        });
                    });
            }

            document.getElementById('filterTanggal').addEventListener('change', loadAntrian);
        </script>

        <!-- Booking Modal -->
        @auth
        <div x-cloak x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm bg-black/50"
            @click.away="open = false">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-gray-800 rounded-3xl shadow-2xl shadow-orange-500/20 border border-gray-700 backdrop-blur-xl w-full max-w-2xl mx-4 transform transition-all duration-300">
                    <div class="p-8 space-y-6">
                        <!-- Header -->
                        <div class="flex justify-between items-center pb-4 border-b border-gray-600 relative">
                            <h3 class="text-2xl font-bold text-white">
                                <i class="fas fa-motorcycle mr-2 text-orange-400"></i>Booking AbakuraRacing Services
                            </h3>
                            <button @click="open = false" class="p-2 hover:bg-gray-700 rounded-full transition-all duration-200">
                                <i class="fas fa-times text-xl text-gray-400 hover:text-orange-400"></i>
                            </button>
                        </div>

                        <!-- Booking Modal -->
                        <form action="{{ route('booking.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <!-- Input Tersembunyi untuk NIK -->
                            <input type="hidden" name="nik" value="{{ Auth::user()->nik }}">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Kolom Kiri -->
                                <div class="space-y-5">
                                    <!-- Tanggal Booking -->
                                    <label class="block text-gray-300">Tanggal Booking</label>
                                    <input type="date" name="tanggal_booking" min="{{ date('Y-m-d') }}" required
                                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white">
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="space-y-5">
                                    <!-- Dropdown Kendaraan -->
                                    <label class="block text-gray-300">Pilih Kendaraan</label>
                                    <select id="kendaraanDropdown" name="nopol" required class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white"
                                        @if(isset($kendaraanUser) && $kendaraanUser->isEmpty()) disabled @endif>
                                        <option value="">Pilih Kendaraan</option>
                                        @foreach($kendaraanUser as $kendaraan)
                                        @php
                                        $isBooked = \App\Models\Booking::where('nopol', $kendaraan->nopol)
                                        ->where('status', '!=', 'Selesai') // Cek apakah masih dalam proses
                                        ->exists();
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

                                    <!-- Auto-Filled Fields -->
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

                            <!-- Input Keluhan -->
                            <label class="block text-gray-300">Keluhan</label>
                            <textarea name="keluhan" placeholder="Masukkan keluhan (opsional)"
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white"></textarea>

                            <!-- Submit Button -->
                            <button type="submit" class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl transition-all duration-300">
                                <i class="fas fa-check-circle"></i> Konfirmasi Booking
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript untuk Auto-Fill Data Kendaraan -->
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

        @if(session('success'))
        <div id="successMessage" class="fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function() {
                document.getElementById('successMessage').style.display = 'none';
            }, 3000);
        </script>
        @endif

        @endauth

        <!-- Our Mechanic Section -->
        <section id="team" class="py-20 px-4 bg-gray-900">
            <div class="max-w-7xl mx-auto">
                <h3 class="text-4xl md:text-5xl font-bold text-center mb-16 text-white animate-fade-in">
                    Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-pink-500">Technicians</span>
                </h3>
                <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                    <!-- Mechanic Card 1 -->
                    <div class="group relative bg-gradient-to-br from-gray-800 to-gray-900 p-1 rounded-3xl shadow-2xl hover:shadow-red-500/30 transition-all duration-500 hover:-translate-y-2">
                        <div class="relative h-full bg-gray-900 rounded-2xl p-6">
                            <div class="relative w-44 h-44 mx-auto mb-6 overflow-hidden rounded-2xl border-4 border-gray-800 hover:border-transparent transition-all duration-500">
                                <img src="{{ asset('img/botak.jpg') }}"
                                    alt="Mechanic 1"
                                    class="absolute inset-0 w-full h-full object-cover opacity-100 group-hover:opacity-0 transition-opacity duration-500">
                                <img src="{{ asset('img/raora.gif') }}"
                                    alt="Mechanic 1 Animated"
                                    class="absolute inset-0 w-full h-full object-cover opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div class="text-center space-y-4">
                                <h4 class="text-2xl font-bold bg-gradient-to-r from-red-400 to-red-600 bg-clip-text text-transparent">
                                    Khanif Durov
                                </h4>
                                <p class="text-gray-400 font-medium">Specialist Scroll Tiktok</p>

                                <!-- Tambahkan relative z-10 supaya tidak tertutup -->
                                <div class="relative z-10 flex justify-center space-x-3 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                    <!-- Instagram -->
                                    <a href="https://www.instagram.com/khanifrokhawi/" target="_blank" rel="noopener noreferrer"
                                        class="p-2 bg-gray-800 rounded-full transition-colors">
                                        <i class="fa-brands fa-instagram text-white text-xl"></i>
                                    </a>
                                    <!-- WhatsApp -->
                                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer"
                                        class="p-2 bg-gray-800 rounded-full transition-colors">
                                        <i class="fa-brands fa-whatsapp text-white text-xl"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Background Gradient, pastikan ini z-0 agar tidak menutupi link -->
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-2xl z-0"></div>
                        </div>
                    </div>

                    <!-- Mechanic Card 2 -->
                    <div class="group relative bg-gradient-to-br from-gray-800 to-gray-900 p-1 rounded-3xl shadow-2xl hover:shadow-red-500/30 transition-all duration-500 hover:-translate-y-2">
                        <div class="relative h-full bg-gray-900 rounded-2xl p-6">
                            <div class="relative w-44 h-44 mx-auto mb-6 overflow-hidden rounded-2xl border-4 border-gray-800 hover:border-transparent transition-all duration-500">
                                <img src="{{ asset('img/montir.jpg') }}"
                                    alt="Mechanic 1"
                                    class="absolute inset-0 w-full h-full object-cover opacity-100 group-hover:opacity-0 transition-opacity duration-500">
                                <img src="{{ asset('img/kaela.gif') }}"
                                    alt="Mechanic 1 Animated"
                                    class="absolute inset-0 w-full h-full object-cover opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div class="text-center space-y-4">
                                <h4 class="text-2xl font-bold bg-gradient-to-r from-red-400 to-red-600 bg-clip-text text-transparent">
                                    Fadil Buffet
                                </h4>
                                <p class="text-gray-400 font-medium">Bor Up/Tune Up Specialist</p>

                                <!-- Tambahkan relative z-10 supaya tidak tertutup -->
                                <div class="relative z-10 flex justify-center space-x-3 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                    <!-- Instagram -->
                                    <a href="https://www.instagram.com/kaelakovalskia/" target="_blank" rel="noopener noreferrer"
                                        class="p-2 bg-gray-800 rounded-full transition-colors">
                                        <i class="fa-brands fa-instagram text-white text-xl"></i>
                                    </a>
                                    <!-- WhatsApp -->
                                    <a href="https://www.youtube.com/@KaelaKovalskia" target="_blank" rel="noopener noreferrer"
                                        class="p-2 bg-gray-800 rounded-full transition-colors">
                                        <i class="fa-brands fa-youtube text-white text-xl"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Background Gradient, pastikan ini z-0 agar tidak menutupi link -->
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-2xl z-0"></div>
                        </div>
                    </div>

                    <!-- Mechanic Card 3 -->
                    <div class="group relative bg-gradient-to-br from-gray-800 to-gray-900 p-1 rounded-3xl shadow-2xl hover:shadow-red-500/30 transition-all duration-500 hover:-translate-y-2">
                        <div class="relative h-full bg-gray-900 rounded-2xl p-6">
                            <div class="relative w-44 h-44 mx-auto mb-6 overflow-hidden rounded-2xl border-4 border-gray-800 hover:border-transparent transition-all duration-500">
                                <img src="{{ asset('img/vitalik.jpg') }}"
                                    alt="Mechanic 1"
                                    class="absolute inset-0 w-full h-full object-cover opacity-100 group-hover:opacity-0 transition-opacity duration-500">
                                <img src="{{ asset('img/shylily.gif') }}"
                                    alt="Mechanic 1 Animated"
                                    class="absolute inset-0 w-full h-full object-cover opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div class="text-center space-y-4">
                                <h4 class="text-2xl font-bold bg-gradient-to-r from-red-400 to-red-600 bg-clip-text text-transparent">
                                    Vitalik Purwana
                                </h4>
                                <p class="text-gray-400 font-medium">Riding Tester</p>

                                <!-- Tambahkan relative z-10 supaya tidak tertutup -->
                                <div class="relative z-10 flex justify-center space-x-3 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                    <!-- Instagram -->
                                    <a href="https://www.instagram.com/womp.womp.everyday/" target="_blank" rel="noopener noreferrer"
                                        class="p-2 bg-gray-800 rounded-full transition-colors">
                                        <i class="fa-brands fa-instagram text-white text-xl"></i>
                                    </a>
                                    <!-- WhatsApp -->
                                    <a href="https://www.youtube.com/@Shylily" target="_blank" rel="noopener noreferrer"
                                        class="p-2 bg-gray-800 rounded-full transition-colors">
                                        <i class="fa-brands fa-youtube text-white text-xl"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Background Gradient, pastikan ini z-0 agar tidak menutupi link -->
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-2xl z-0"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Elegant Divider -->
        <div class="relative flex items-center justify-center my-12">
            <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-500 to-transparent"></div>
            <span class="absolute bg-gray-900 px-4 text-gray-300 text-lg font-semibold">
                ★
            </span>
        </div>

        <!-- Gallery Section -->
        <section class="py-24 px-4 bg-gradient-to-b from-gray-900 to-black relative overflow-hidden">
            <!-- Background Grid Pattern -->
            <div class="absolute inset-0 opacity-10 bg-[length:40px_40px] bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)]"></div>

            <div class="max-w-7xl mx-auto relative z-10">
                <h3 class="text-4xl md:text-6xl font-bold text-center mb-16 text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-pink-400 hover:from-pink-400 hover:to-red-400 transition-all duration-500">
                    Our <span class="font-black bg-gradient-to-r from-pink-400 to-red-400 bg-clip-text text-transparent">Masterpiece</span>
                </h3>

                <!-- Swiper Container -->
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <!-- Gallery Items -->
                        <div class="swiper-slide group">
                            <div class="relative overflow-hidden rounded-2xl cursor-pointer h-[500px] transform transition-all duration-500 hover:scale-[0.98]">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                                <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                                <img src="img/mx.jpg" alt="Gallery Image"
                                    class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">

                                <!-- Content Card -->
                                <div class="absolute bottom-4 left-4 right-4 z-20 bg-white/5 backdrop-blur-xl rounded-xl p-6 transition-all duration-500 transform translate-y-20 group-hover:translate-y-0">
                                    <h4 class="text-2xl font-bold text-white mb-8 flex items-center">
                                        <span class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                                        Sengkuni
                                    </h4>
                                    <div class="flex justify-between items-center">
                                        <p class="text-gray-300 font-mono">UP 300</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide group">
                            <div class="relative overflow-hidden rounded-2xl cursor-pointer h-[500px] transform transition-all duration-500 hover:scale-[0.98]">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                                <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                                <img src="img/aa.jpg" alt="Gallery Image"
                                    class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">

                                <!-- Content Card -->
                                <div class="absolute bottom-4 left-4 right-4 z-20 bg-white/5 backdrop-blur-xl rounded-xl p-6 transition-all duration-500 transform translate-y-20 group-hover:translate-y-0">
                                    <h4 class="text-2xl font-bold text-white mb-8 flex items-center">
                                        <span class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                                        Kuyang
                                    </h4>
                                    <div class="flex justify-between items-center">
                                        <p class="text-gray-300 font-mono">UP 291</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide group">
                            <div class="relative overflow-hidden rounded-2xl cursor-pointer h-[500px] transform transition-all duration-500 hover:scale-[0.98]">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                                <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                                <img src="img/cb.jpg" alt="Gallery Image"
                                    class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">

                                <!-- Content Card -->
                                <div class="absolute bottom-4 left-4 right-4 z-20 bg-white/5 backdrop-blur-xl rounded-xl p-6 transition-all duration-500 transform translate-y-20 group-hover:translate-y-0">
                                    <h4 class="text-2xl font-bold text-white mb-8 flex items-center">
                                        <span class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                                        Plima
                                    </h4>
                                    <div class="flex justify-between items-center">
                                        <p class="text-gray-300 font-mono">turbo</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide group">
                            <div class="relative overflow-hidden rounded-2xl cursor-pointer h-[500px] transform transition-all duration-500 hover:scale-[0.98]">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                                <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                                <img src="img/cc.jpg" alt="Gallery Image"
                                    class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">

                                <!-- Content Card -->
                                <div class="absolute bottom-4 left-4 right-4 z-20 bg-white/5 backdrop-blur-xl rounded-xl p-6 transition-all duration-500 transform translate-y-20 group-hover:translate-y-0">
                                    <h4 class="text-2xl font-bold text-white mb-8 flex items-center">
                                        <span class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                                        Jangwe
                                    </h4>
                                    <div class="flex justify-between items-center">
                                        <p class="text-gray-300 font-mono">Tipu Jarak</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide group">
                            <div class="relative overflow-hidden rounded-2xl cursor-pointer h-[500px] transform transition-all duration-500 hover:scale-[0.98]">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                                <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                                <img src="img/mio.jpg" alt="Gallery Image"
                                    class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">

                                <!-- Content Card -->
                                <div class="absolute bottom-4 left-4 right-4 z-20 bg-white/5 backdrop-blur-xl rounded-xl p-6 transition-all duration-500 transform translate-y-20 group-hover:translate-y-0">
                                    <h4 class="text-2xl font-bold text-white mb-8 flex items-center">
                                        <span class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                                        mio
                                    </h4>
                                    <div class="flex justify-between items-center">
                                        <p class="text-gray-300 font-mono">Kopling Sepele up 345</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide group">
                            <div class="relative overflow-hidden rounded-2xl cursor-pointer h-[500px] transform transition-all duration-500 hover:scale-[0.98]">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                                <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                                <img src="img/tipen.jpg" alt="Gallery Image"
                                    class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">

                                <!-- Content Card -->
                                <div class="absolute bottom-4 left-4 right-4 z-20 bg-white/5 backdrop-blur-xl rounded-xl p-6 transition-all duration-500 transform translate-y-20 group-hover:translate-y-0">
                                    <h4 class="text-2xl font-bold text-white mb-8 flex items-center">
                                        <span class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                                        Tipen
                                    </h4>
                                    <div class="flex justify-between items-center">
                                        <p class="text-gray-300 font-mono">Goib</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide group">
                            <div class="relative overflow-hidden rounded-2xl cursor-pointer h-[500px] transform transition-all duration-500 hover:scale-[0.98]">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                                <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                                <img src="img/tipenold.jpg" alt="Gallery Image"
                                    class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">

                                <!-- Content Card -->
                                <div class="absolute bottom-4 left-4 right-4 z-20 bg-white/5 backdrop-blur-xl rounded-xl p-6 transition-all duration-500 transform translate-y-20 group-hover:translate-y-0">
                                    <h4 class="text-2xl font-bold text-white mb-8 flex items-center">
                                        <span class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                                        Tipen Old
                                    </h4>
                                    <div class="flex justify-between items-center">
                                        <p class="text-gray-300 font-mono">🥀</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tambahkan slide lainnya dengan struktur yang sama -->
                    </div>

                    <!-- Navigation buttons -->
                    <div class="swiper-button-next !w-14 !h-14 !bg-black/30 hover:!bg-black/50 backdrop-blur-sm rounded-full !right-4 hover:!scale-110 transition-transform"></div>
                    <div class="swiper-button-prev !w-14 !h-14 !bg-black/30 hover:!bg-black/50 backdrop-blur-sm rounded-full !left-4 hover:!scale-110 transition-transform"></div>

                    <!-- Pagination -->
                    <div class="swiper-pagination !relative !mt-8"></div>
                </div>
            </div>

            <!-- Animated Background Elements -->
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute -right-32 -top-32 w-96 h-96 bg-pink-500/10 rounded-full blur-3xl animate-spin-slow"></div>
                <div class="absolute -left-32 -bottom-32 w-96 h-96 bg-red-500/10 rounded-full blur-3xl animate-spin-slow-reverse"></div>
            </div>
        </section>

        <!-- footer section -->

        <footer class="relative min-h-[60vh] overflow-hidden bg-gradient-to-br from-zinc-900 via-[#0a0a0a] to-black">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute -top-1/3 left-1/4 w-[800px] h-[800px] bg-gradient-to-r from-violet-600/30 to-transparent rounded-full blur-[100px] animate-rotate"></div>
                <div class="absolute top-1/2 right-0 w-[600px] h-[600px] bg-gradient-to-l from-rose-600/20 to-transparent rounded-full blur-[120px] animate-pulse"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-6 md:px-12 py-24 grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-8">
                <!-- Logo Section with 3D Effect -->
                <div class="space-y-6 transform perspective-1000 hover:rotate-y-6 transition-all duration-500">
                    <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 p-6 rounded-2xl backdrop-blur-xl border border-zinc-700/50 shadow-2xl">
                        <span class="text-2xl font-bold bg-gradient-to-r from-red-400 to-rose-600 bg-clip-text text-transparent">
                            AbakuraRacing
                        </span>
                        <p class="mt-4 text-zinc-400 text-sm leading-relaxed">
                            Revolutionizing automotive excellence with cutting-edge technology and precision engineering.
                        </p>
                    </div>
                </div>

                <!-- Navigation Links with Hover Effects -->
                <div class="flex flex-col gap-4">
                    <div class="bg-zinc-900/30 p-6 rounded-xl backdrop-blur-lg border border-zinc-800/50 hover:border-rose-500/30 transition-all">
                        <h5 class="text-rose-400 font-semibold mb-3">Explore</h5>
                        <ul class="space-y-2.5">
                            <li><a href="#work" class="flex items-center group">
                                    <span class="h-px w-3 bg-rose-500 mr-2 transition-all group-hover:w-5"></span>
                                    <span class="text-zinc-300 group-hover:text-rose-100 transition-all">Our Work</span>
                                </a></li>
                            <li><a href="#team" class="flex items-center group">
                                    <span class="h-px w-3 bg-amber-500 mr-2 transition-all group-hover:w-5"></span>
                                    <span class="text-zinc-300 group-hover:text-amber-100">Racing Team</span>
                                </a></li>
                            <li><a href="#booking" class="flex items-center group">
                                    <span class="h-px w-3 bg-blue-500 mr-2 transition-all group-hover:w-5"></span>
                                    <span class="text-zinc-300 group-hover:text-blue-100">Booking</span>
                                </a></li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Section with Interactive Icons -->
                <div class="bg-zinc-900/30 p-6 rounded-xl backdrop-blur-lg border border-zinc-800/50 hover:border-blue-500/30 transition-all">
                    <h5 class="text-blue-400 font-semibold mb-4">Connect</h5>
                    <ul class="space-y-3">
                        <li class="flex items-center group">
                            <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-500/20 transition">
                                <i class="fas fa-phone text-blue-400 text-sm"></i>
                            </div>
                            <span class="text-zinc-300 group-hover:text-blue-100 transition">+62 812 3456 7890</span>
                        </li>
                        <li class="flex items-center group">
                            <div class="w-8 h-8 bg-rose-500/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-rose-500/20 transition">
                                <i class="fas fa-envelope text-rose-400 text-sm"></i>
                            </div>
                            <span class="text-zinc-300 group-hover:text-rose-100 transition">race@abakura.id</span>
                        </li>
                        <li class="flex items-center group">
                            <div class="w-8 h-8 bg-amber-500/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-amber-500/20 transition">
                                <i class="fas fa-map-marker-alt text-amber-400 text-sm"></i>
                            </div>
                            <span class="text-zinc-300 group-hover:text-amber-100 transition">Jakarta Speed City</span>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter with Floating Effect -->
                <div class="lg:col-span-2 transform transition hover:-translate-y-1 duration-300">
                    <div class="bg-gradient-to-br from-zinc-900 to-zinc-800/50 p-8 rounded-2xl backdrop-blur-xl border border-zinc-700/50 shadow-xl">
                        <h5 class="text-2xl font-semibold bg-gradient-to-r from-rose-400 to-amber-400 bg-clip-text text-transparent mb-6">Get Updates</h5>
                        <form class="space-y-5">
                            <input type="email"
                                class="w-full px-5 py-4 bg-zinc-800/50 border border-zinc-700 rounded-xl text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-rose-500/50 transition-all"
                                placeholder="Enter your email...">
                            <button class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-rose-600 to-amber-500 text-white font-semibold py-4 px-8 rounded-xl transition-all hover:shadow-lg hover:shadow-rose-500/20">
                                Subscribe Now
                                <i class="fas fa-arrow-right text-sm ml-2 animate-pulse-horizontal"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Animated Social Links -->
            <div class="relative max-w-7xl mx-auto px-6 md:px-12 pb-12">
                <div class="border-t border-zinc-800 pt-12">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                        <div class="flex space-x-6">
                            <a href="#" class="social-icon">
                                <i class="fab fa-instagram text-zinc-400 hover:text-rose-500"></i>
                            </a>
                            <a href="#" class="social-icon">
                                <i class="fab fa-youtube text-zinc-400 hover:text-red-500"></i>
                            </a>
                            <a href="#" class="social-icon">
                                <i class="fab fa-tiktok text-zinc-400 hover:text-cyan-500"></i>
                            </a>
                        </div>
                        <span class="text-zinc-500 text-sm text-center md:text-right">
                            © 2023 <span class="text-gradient">AbakuraRacing</span>. Crafted with passion
                        </span>
                    </div>
                </div>
            </div>

            <!-- Custom Animations -->
            <style>
                @keyframes rotate {
                    from {
                        transform: rotate(0deg);
                    }

                    to {
                        transform: rotate(360deg);
                    }
                }

                @keyframes pulse {

                    0%,
                    100% {
                        opacity: 1;
                    }

                    50% {
                        opacity: 0.3;
                    }
                }

                .animate-rotate {
                    animation: rotate 120s linear infinite;
                }

                .animate-pulse {
                    animation: pulse 8s ease-in-out infinite;
                }

                .text-gradient {
                    background: linear-gradient(45deg, #f43f5e, #eab308);
                    -webkit-background-clip: text;
                    background-clip: text;
                    color: transparent;
                }

                .social-icon {
                    @apply w-12 h-12 rounded-xl bg-zinc-800/50 border border-zinc-700 flex items-center justify-center text-xl transition-all hover:-translate-y-1 hover:shadow-lg;
                }

                .animate-pulse-horizontal {
                    animation: pulse-horizontal 1.5s ease-in-out infinite;
                }

                @keyframes pulse-horizontal {

                    0%,
                    100% {
                        transform: translateX(0);
                    }

                    50% {
                        transform: translateX(4px);
                    }
                }
            </style>
        </footer>

    </body>

</html>