<div id="pinCode" class="bg-black/70 h-screen w-full fixed top-0 left-0 z-30 hidden" >

        <div class="bg-white rounded-3xl p-5 w-[300px] mx-auto mt-10 md:mt-5">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800 text-center">Masukan PIN Anda</h2>
            <div>
              {{-- AUTOMATIC SUBMIT KETIKA SEMUA INPUT TERISI --}}
                <form action="/dashboard/kode-qr" method="post" id="formpin">
                  <div class="flex flex-col space-y-16">
                    <div class="flex flex-row items-center justify-between mx-auto w-full max-w-xs gap-2">
                      <div class="w-16 h-16">
                        <input class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none rounded-xl border-2 border-gray-500 text-2xl bg-white focus:bg-gray-50 focus:border-utama otp-input" type="number" name="" id="" maxlength="1" autofocus>
                      </div>
                      <div class="w-16 h-16">
                        <input class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none rounded-xl border-2 border-gray-500 text-2xl bg-white focus:bg-gray-50 focus:border-utama otp-input" type="number" name="" id="" maxlength="1">
                      </div>
                      <div class="w-16 h-16">
                        <input class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none rounded-xl border-2 border-gray-500 text-2xl bg-white focus:bg-gray-50 focus:border-utama otp-input" type="number" name="" id="" maxlength="1">
                      </div>
                      <div class="w-16 h-16">
                        <input class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none rounded-xl border-2 border-gray-500 text-2xl bg-white focus:bg-gray-50 focus:border-utama otp-input" type="number" name="" id="" maxlength="1">
                      </div>
                    </div>
                  </div>
                </form>
                <div class="mt-6">
                  <button id="closePinCodeBtn" class="bg-utama text-white rounded-lg font-medium px-5 py-2 text-md hover:bg-teal-800 w-full">
                      Tutup
                  </button>
              </div>
            </div>
        </div>
</div>