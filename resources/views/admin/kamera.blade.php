@extends('layouts.main')
@section('container')
    @include('partials.scancam')
    <div class="px-3 py-6 md:p-6 mb-5">
        <div class="flex justify-between items-center">
            <div class="mx-auto py-[200px] hidden lg:block">
                <div class="text-7xl text-utama font-semibold">Camera Scanner</div>
                <div class="text-gray-400 text-lg mt-3">Scan kode QR siswa dengan kamera scanner petugas piket</div>
            </div>
            <div class="bg-utama rounded-lg text-white div-shadow-kodeqr w-full md:w-[350px] mx-auto p-3 md:p-5">
                <div class="relative max-w-sm transition-all duration-300 filter mx-auto w-[60%] mt-5">
                    <svg xmlns="http://www.w3.org/2000/svg" style="fill: white;" viewBox="0 0 24 24">
                        <path
                            d="M9.82843 5L7.82843 7H4V19H20V7H16.1716L14.1716 5H9.82843ZM9 3H15L17 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V6C2 5.44772 2.44772 5 3 5H7L9 3ZM12 18C8.96243 18 6.5 15.5376 6.5 12.5C6.5 9.46243 8.96243 7 12 7C15.0376 7 17.5 9.46243 17.5 12.5C17.5 15.5376 15.0376 18 12 18ZM12 16C13.933 16 15.5 14.433 15.5 12.5C15.5 10.567 13.933 9 12 9C10.067 9 8.5 10.567 8.5 12.5C8.5 14.433 10.067 16 12 16Z">
                        </path>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg"></div>
                        <div class="relative z-10">
                            <button id="showScanCamBtn"
                                class="bg-[#0079FF] text-white rounded-lg font-medium px-5 py-2 text-md hover:bg-blue-700 w-full h-full">
                                Buka
                            </button>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <div class="text-xl font-medium">Kamera Scanner</div>
                    <div class="text-sm">Buka kamera Anda untuk scan kode QR siswa</div>
                </div>
                <div class="bg-teal-600 w-[95%] mx-auto rounded-lg mt-5 p-3">
                    <h1 class="font-medium text-md text-white">Profil Anda</h1>
                    <div class="border-b border-gray-300 mt-1 mb-3"></div>
                    <div class="flex items-center mb-2 ml-2">
                        <img src="https://placehold.co/36x36" class="rounded-full w-9 h-9 md:w-12 md:h-12"
                            alt="Foto Profil">
                        <div class="ml-3">
                            <p class="text-sm text-gray-200">{{ $user->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-teal-600 w-[95%] mx-auto rounded-lg mt-5 p-3 mb-5">
                    <h1 class="font-medium text-md text-white">Piket hari ini</h1>
                    <div class="border-b border-gray-300 mt-1 mb-3"></div>
                    <div class="flex items-center">
                        <p class="text-sm font-normal text-white p-1">{{ $petugas1 }}</p>
                    </div>
                    <div class="flex items-center">
                        <p class="text-sm font-normal text-white p-1">{{ $petugas2 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/scancamera.js') }}"></script>
@endsection
