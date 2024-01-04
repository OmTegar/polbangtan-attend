@extends('layouts.main')
@section('container')
    <div class="px-3 py-6 md:p-6 mb-5">
        <h1 class="font-semibold text-2xl md:text-3xl mb-3">Piket Petugas</h1>
        <div class="text-gray-600 text-sm">Jadwal piket petugas E-Absen Asrama Polbangtan-mlg</div>
        <div class="border-b border-gray-300 my-5"></div>
        <div class="bg-white rounded-lg p-3 mt-5 shadow-xl">
            {{-- alert --}}
            @if (session()->has('success'))
                <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-200" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                    <button type="button"
                        class="ml-auto -mx-1.5 -my-1.5 bg-green-200 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
                        data-dismiss-target="#alert-3" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
            @endif
            @if (session()->has('error'))
                <div id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-200" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                    <button type="button"
                        class="ml-auto -mx-1.5 -my-1.5 bg-red-200 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8"
                        data-dismiss-target="#alert-2" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
            @endif
            <div class="flex flex-col md:flex-row px-4 items-start md:items-center justify-between">
                <div class="">
                    <div class="text-gray-900 text-lg font-medium">Daftar Petugas</div>
                    <div class="text-gray-600 text-sm mt-2 pr-2">Berikut pengaturan jadwal petugas Asrama Polbangtan-mlg</div>
                </div>
                <div class="w-full md:w-[250px] mt-2">
                    <form action="{{ route('admin.piketPetugas') }}" method="get" class="flex w-full">
                        @csrf
                        <input type="date" name="search" class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-utama focus:border-utama w-full p-2.5 mr-1">
                        <button type="submit" class="bg-utama hover:bg-teal-800 text-white rounded-lg px-3 py-1.5 text-sm">Cari</button>
                    </form>
                </div>
            </div>
            <div class="flex flex-col md:flex-row mb-3 gap-1 md:gap-2 px-4 mt-1 md:mt-1">
                <a href="{{ route('admin.piketPetugasGenerateJadwalMingguan') }}"
                class="bg-utama hover:bg-teal-800 text-white rounded-lg py-2 px-3 text-center text-sm items-center justify-center flex">
                <i class="ri-add-line text-md mr-1"></i>Create Jadwal mingguan</a>
                <button id="createJadwalButton"
                    class="bg-utama hover:bg-teal-800 text-white rounded-lg py-2 px-3 text-sm text-center flex justify-center items-center">
                    <i class="ri-add-line text-md mr-1"></i>Create Jadwal
                </button>
            </div>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase  bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Petugas
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($petugas->count() == 0)
                            <tr class="bg-white border-b">
                                <td colspan="4" class="px-6 py-4 text-center">Tidak ada data</td>
                            </tr>
                        @else
                            @foreach ($petugas as $item)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($item->date)->format('d F Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-utama focus:border-utama block w-full p-2">
                                            {{ $item->petugas1 ? $item->petugas1->name : '-' }}
                                        </span>
                                        <span
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-utama focus:border-utama block w-full p-2">
                                            {{ $item->petugas2 ? $item->petugas2->name : '-' }}
                                        </span>

                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-1">
                                            <a href="{{ route('admin.showPiketPetugasSingle', ['id' => $item->id]) }}"
                                                class="bg-orange-500 hover:bg-orange-800 text-white rounded p-2 edit-button">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                {{-- PAGINATION --}}
                <div class="bg-white p-4 flex items-center flex-wrap">
                    <nav aria-label="Page navigation">
                        <ul class="inline-flex">
                            @if ($petugas->onFirstPage())
                                <!-- Tombol Previous Tidak Aktif Jika Di Halaman Pertama -->
                                <button class="h-10 px-5 text-gray-400" disabled>
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                            @else
                                <!-- Tombol Previous Aktif -->
                                <a href="{{ $petugas->previousPageUrl() }}">
                                    <button
                                        class="h-10 px-5 text-utama transition-colors duration-150 rounded-full focus:shadow-outline hover:bg-green-100">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                clip-rule="evenodd" fill-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </a>
                            @endif

                            <!-- Tampilkan Nomor Halaman -->
                            @php
                                // Menentukan jumlah halaman yang akan ditampilkan di sekitar halaman saat ini
                                $showPages = 3;
                                $startPage = max($petugas->currentPage() - $showPages, 1);
                                $endPage = min($petugas->currentPage() + $showPages, $petugas->lastPage());
                            @endphp

                            @if ($startPage > 1)
                                <!-- Tampilkan Tombol Halaman Pertama Jika Ada Halaman Sebelumnya -->
                                <a href="{{ $petugas->url(1) }}">
                                    <button
                                        class="h-10 px-5 text-utama transition-colors duration-150 focus:shadow-outline hover:bg-green-100 rounded-full">
                                        1
                                    </button>
                                </a>
                                <!-- Tampilkan Elipsis Jika Ada Halaman Sebelumnya Yang Tidak Ditampilkan -->
                                <span class="h-10 px-5 text-gray-400">...</span>
                            @endif

                            @for ($i = $startPage; $i <= $endPage; $i++)
                                <!-- Tampilkan Nomor Halaman -->
                                <a href="{{ $petugas->url($i) }}">
                                    <button
                                        class="h-10 px-5 @if ($i == $petugas->currentPage()) bg-utama text-white rounded-full @else text-utama hover:bg-green-100 rounded-full @endif transition-colors duration-150">
                                        {{ $i }}
                                    </button>
                                </a>
                            @endfor

                            @if ($endPage < $petugas->lastPage())
                                <!-- Tampilkan Elipsis Jika Ada Halaman Selanjutnya Yang Tidak Ditampilkan -->
                                <span class="h-10 px-5 text-gray-400">...</span>
                                <!-- Tampilkan Tombol Halaman Terakhir Jika Ada Halaman Selanjutnya -->
                                <a href="{{ $petugas->url($petugas->lastPage()) }}">
                                    <button
                                        class="h-10 px-5 text-utama transition-colors duration-150 hover:bg-green-100 rounded-full">
                                        {{ $petugas->lastPage() }}
                                    </button>
                                </a>
                            @endif

                            @if ($petugas->hasMorePages())
                                <!-- Tombol Next Aktif -->
                                <a href="{{ $petugas->nextPageUrl() }}">
                                    <button
                                        class="h-10 px-5 text-utama transition-colors duration-150 focus:shadow-outline hover:bg-green-100 rounded-full">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" fill-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </a>
                            @else
                                <!-- Tombol Next Tidak Aktif Jika Di Halaman Terakhir -->
                                <button class="h-10 px-5 text-gray-400" disabled>
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l-4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                            @endif
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>

    @include('admin.jadwal-custom')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const createJadwalButton = document.getElementById('createJadwalButton');
            const closeJadwalButton = document.getElementById('closeJadwalButton');
            const createJadwalModal = document.getElementById('createJadwalModal');

            createJadwalButton.addEventListener('click', function() {
                createJadwalModal.classList.remove('hidden');
            });

            closeJadwalButton.addEventListener('click', function() {
                createJadwalModal.classList.add('hidden');
            });
        });
    </script>
@endsection
