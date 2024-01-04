<div id="scanCam" class="bg-black/70 h-screen w-full fixed top-0 left-0 z-30 hidden">
    <div class="bg-white rounded-3xl p-5 w-[90%] md:max-w-[50%] mx-auto mt-2">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800 text-center">Scanner QR Code</h2>
        <div class="flex items-center my-5 ml-2">
            <img src="https://placehold.co/36x36" class="rounded-xl w-[55px] h-[55px] md:w-12 md:h-12" alt="Foto Profil">
            <div class="ml-3">
                <p class="text-sm font-semibold text-black">{{ $user->name }}</p>
                <p class="text-sm text-gray-700"></p>
            </div>
        </div>
        <select id="camera" class="rounded bg-utama border-teal-900 text-gray-100 mb-3 mx-auto focus:ring-teal-500 focus:border-teal-500 block flex-1 w-[200px] text-sm p-2.5">
            <option hidden selected>Pilih Kamera</option>
        </select>
        <div class="flex justify-center items-center mb-4">
            <video id="preview" width="400" height="400"></video>
        </div>

        <p class="text-gray-600 text-sm text-center">Pindai kode QR dengan camera scanner</p>

        <div class="mt-6">
            <button id="closeScanCamBtn" class="bg-utama text-white rounded-lg font-medium px-5 py-2 text-md hover:bg-teal-800 w-full">
                Tutup Kamera
            </button>
        </div>
        <form action="{{ route('presense.api') }}" method="post" id="form">
            @csrf
            <input type="hidden" name="user_id" id="user_id">
            <input type="hidden" name="date" id="date">
            <input type="hidden" name="time" id="time">
            <input type="hidden" name="status" id="status">
        </form>
    </div>
</div>

