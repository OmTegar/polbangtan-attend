<div id="qrCode" class="bg-black/70 h-screen w-full fixed top-0 left-0 z-30 hidden">
    <div class="bg-white rounded-3xl p-5 w-[90%] md:max-w-[50%] mx-auto mt-10 md:mt-5">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800 text-center">My QR Code</h2>
        <div class="flex items-center my-5 ml-2">
            <img src="https://placehold.co/36x36" class="rounded-xl w-[55px] h-[55px] md:w-12 md:h-12" alt="Foto Profil">
            <div class="ml-3">
                <p class="text-sm font-semibold text-black">{{ $user->name }}</p>
                <p class="text-sm text-gray-700">{{ $user->blok->name }}{{ $user->no_kamar }}</p>
            </div>
        </div>
        <div class="flex justify-center items-center mb-4">
            {{ $QrCode }}
        </div>

        <p class="text-gray-600 text-sm">Pindai kode QR untuk melakukan presensi keluar asrama.</p>

        <div class="mt-6">
            <button id="closeQRCodeBtn" class="bg-utama text-white rounded-lg font-medium px-5 py-2 text-md hover:bg-teal-800 w-full">
                Tutup Kode QR
            </button>
        </div>
    </div>
</div>