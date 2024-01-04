<div
    class="fixed left-0 top-0 w-64 h-full bg-teal-800 p-4 z-30 sidebar-menu transition-transform -translate-x-full md:-translate-x-0">
    <a href="/" class="flex items-center pb-4 border-b border-b-teal-900">
        <img src="{{ asset('img/logo-asrama2.jpeg') }}" alt="" class="w-8 h-8 rounded object-cover">
        <span class="text-lg font-bold text-white ml-3">E-Absen Asrama</span>
    </a>
    <ul class="mt-1">
        @if (Auth::check() && Auth::user()->role_id == '3')
            <h6 class="md:min-w-full text-white text-sm uppercase font-bold block pt-1 px-2 mt-5 no-underline">
                User Layout Pages
            </h6>
            <li class="mb-1 group active">
                <a href="/dashboard"
                    class="{{ Request::is('dashboard') ? 'text-white bg-utama' : 'text-gray-300 hover:bg-teal-950 hover:text-gray-100' }} flex items-center py-2 px-4 rounded-md">
                    <i class="ri-home-2-line mr-3 text-lg"></i>
                    <span class="text-sm">Dashboard</span>
                </a>
            </li>
            <li class="mb-1 group">
                <a href="/dashboard/kode-qr"
                    class="{{ Request::is('dashboard/kode-qr') ? 'text-white bg-utama' : 'text-gray-300 hover:bg-teal-950 hover:text-gray-100' }} flex items-center py-2 px-4 rounded-md">
                    <i class="ri-qr-code-line mr-3 text-lg"></i>
                    <span class="text-sm">Kode QR</span>
                </a>
            </li>
            <li class="mb-1 group">
                <a href="/dashboard/profil"
                    class="{{ Request::is('dashboard/profil') ? 'text-white bg-utama' : 'text-gray-300 hover:bg-teal-950 hover:text-gray-100' }} flex items-center py-2 px-4 rounded-md">
                    <i class="ri-user-line mr-3 text-lg"></i>
                    <span class="text-sm">Profil</span>
                </a>
            </li>
            <li class="mb-1 group">
                <a href="/dashboard/riwayat-absen"
                    class="{{ Request::is('dashboard/riwayat-absen') ? 'text-white bg-utama' : 'text-gray-300 hover:bg-teal-950 hover:text-gray-100' }} flex items-center py-2 px-4 rounded-md">
                    <i class="ri-history-line mr-3 text-lg"></i>
                    <span class="text-sm">Riwayat Absensi</span>
                </a>
            </li>
        @endif
        {{-- <li class="mb-1 group">
            <a href="#" class="flex items-center py-2 px-4 text-gray-300 hover:bg-teal-950 hover:text-gray-100 rounded-md group-[.active]:bg-utama group-[.active]:text-white group-[.selected]:bg-teal-950 group-[.selected]:text-gray-100">
                <i class="ri-settings-2-line mr-3 text-lg"></i>
                <span class="text-sm">Pengaturan</span>
            </a>
        </li> --}}
        @if (Auth::check() && (Auth::user()->role_id == 1 || Auth::user()->role_id == 2))
            <ul class="mt-1">
                <li class="mb-1 group">
                    <a href="/dashboard-admin"
                        class="{{ Request::is('dashboard-admin') ? 'text-white bg-utama' : 'text-gray-300 hover:bg-teal-950 hover:text-gray-100' }} flex items-center py-2 px-4 rounded-md">
                        <i class="ri-home-2-line mr-3 text-lg"></i>
                        <span class="text-sm">Dashboard Admin</span>
                    </a>
                </li>
                <li class="mb-1 group">
                    <a href="/data-mahasiswa"
                        class="{{ Request::is('data-mahasiswa') ? 'text-white bg-utama' : 'text-gray-300 hover:bg-teal-950 hover:text-gray-100' }} flex items-center py-2 px-4 rounded-md">
                        <i class="ri-database-2-line mr-3 text-lg"></i>
                        <span class="text-sm">Data Mahasiswa</span>
                    </a>
                </li>
                <li class="mb-1 group">
                    <a href="/absensi-mahasiswa"
                        class="{{ Request::is('absensi-mahasiswa') ? 'text-white bg-utama' : 'text-gray-300 hover:bg-teal-950 hover:text-gray-100' }} flex items-center py-2 px-4 rounded-md">
                        <i class="ri-survey-line mr-3 text-lg"></i>
                        <span class="text-sm">Absensi Mahasiswa</span>
                    </a>
                </li>
                <li class="mb-1 group">
                    <a href="/data-petugas"
                        class="{{ Request::is('data-petugas') ? 'text-white bg-utama' : 'text-gray-300 hover:bg-teal-950 hover:text-gray-100' }} flex items-center py-2 px-4 rounded-md">
                        <i class="ri-admin-line mr-3 text-lg"></i>
                        <span class="text-sm">Data Petugas</span>
                    </a>
                </li>
                <li class="mb-1 group">
                    <a href="/piket-petugas"
                        class="{{ Request::is('piket-petugas') ? 'text-white bg-utama' : 'text-gray-300 hover:bg-teal-950 hover:text-gray-100' }} flex items-center py-2 px-4 rounded-md">
                        <i class="ri-bubble-chart-line mr-3 text-lg"></i>
                        <span class="text-sm">Piket Petugas</span>
                    </a>
                </li>
                <li class="mb-1 group">
                    <a href="/kamera-scan"
                        class="{{ Request::is('kamera-scan') ? 'text-white bg-utama' : 'text-gray-300 hover:bg-teal-950 hover:text-gray-100' }} flex items-center py-2 px-4 rounded-md">
                        <i class="ri-camera-line mr-3 text-lg"></i>
                        <span class="text-sm">Scanner QR</span>
                    </a>
                </li>
                <li class="mb-1 group">
                    <a href="/generate-laporan"
                        class="{{ Request::is('generate-laporan') ? 'text-white bg-utama' : 'text-gray-300 hover:bg-teal-950 hover:text-gray-100' }} flex items-center py-2 px-4 rounded-md">
                        <i class="ri-file-list-3-line mr-3 text-lg"></i>
                        <span class="text-sm">Generate Laporan</span>
                    </a>
                </li>
                <li class="mb-1 group">
                    <a href="/sistem-admin"
                        class="{{ Request::is('sistem-laporan') ? 'text-white bg-utama' : 'text-gray-300 hover:bg-teal-950 hover:text-gray-100' }} flex items-center py-2 px-4 rounded-md">
                        <i class="ri-settings-2-line mr-3 text-lg"></i>
                        <span class="text-sm">Sistem Admin</span>
                    </a>
                </li>
            </ul>
        @endif

    </ul>
</div>
<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-20 hidden md:hidden sidebar-overlay"></div>
