@extends('layouts.main')
@section('container')
    <div class="px-3 py-6 md:p-6 mb-5">
        <h1 class="font-semibold text-2xl md:text-3xl mb-3">Data Absen Mahasiswa</h1>
        <div class="text-gray-600 text-sm">Data absen mahasiswa per waktu dan tanggal</div>
        <div class="border-b border-gray-300 my-5"></div>
        <div class="w-auto bg-white border-2 rounded-lg p-3">
            <div class="pb-2">Daftar Ruangan</div>
            <div class="flex flex-col md:flex-row items-center md:items-end gap-2">
                <div class="items-center w-full md:w-auto">
                    <select id="blok_ruangan"
                        class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-utama focus:border-utama block w-full p-2.5">
                        <option selected hidden>Pilih Blok Ruangan</option>
                        @foreach ($blokRuangan as $blok)
                            <option value="{{ $blok->id }}">{{ $blok->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-auto">
                    <select id="nomor_ruangan" name="nomor_ruangan"
                        class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-utama focus:border-utama block w-full p-2.5">
                        <option selected hidden>-</option>
                    </select>
                </div>
                {{-- <div class="w-full md:w-auto">
                    <input type="date" name="" id=""
                        class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-utama focus:border-utama block w-full p-2.5">
                </div> --}}
            </div>
        </div>

        <div class="bg-white rounded-lg p-3 mt-5 border-2">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center p-4">
                <div class="">
                    <div class="text-gray-900 text-lg font-medium">Absen Mahasiswa</div>
                    <div class="text-gray-600 text-sm mt-2">Daftar mahasiswa tertera dibawah</div>
                </div>
                <div class="font-semibold text-2xl mt-5 md:mt-0">B20</div>

            </div>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase  bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 w-[10px]">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3 w-[10px]">
                                NIM
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Keterangan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jam Keluar Asrama
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jam Kembali Asrama
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tanggal
                            </th>
                        </tr>
                    </thead>
                    <tbody id="result">
                        @foreach ($mergedData as $item)
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $loop->iteration + $mergedData->firstItem() - 1 }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $item->nim }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->name }}
                                </td>
                                <td class="px-6 py-4">
                                @if ($item->status == 'didalam')
                                    <div class="bg-green-500 text-white rounded p-1 text-center">Di dalam Asrama
                                    </div>
                                @elseif ($item->status == 'diluar')
                                    <div class="bg-red-500 text-white rounded p-1 text-center">Di luar Asrama</div>
                                @elseif ($item->status == 'telat')
                                    <div class="bg-orange-500 text-white rounded p-1 text-center">Telat Masuk Asrama
                                    </div>
                                @endif
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $presenceKeluarArray = explode(',', $item->presence_keluar);
                                    @endphp
                                    @if (count($presenceKeluarArray) > 0)
                                        @foreach ($presenceKeluarArray as $presence)
                                            <div class="py-1">
                                                {{ $presence }}
                                            </div>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $presenceMasukArray = explode(',', $item->presence_masuk);
                                    @endphp
                                    @if (count($presenceMasukArray) > 0)
                                        @foreach ($presenceMasukArray as $presence)
                                            <div class="py-1">
                                                {{ $presence }}
                                            </div>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::today()->format('d F Y') }}<br>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="bg-white p-4 flex items-center flex-wrap">
                    <nav aria-label="Page navigation">
                        <ul class="inline-flex">
                            @if ($mergedData->onFirstPage())
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
                                <a href="{{ $mergedData->previousPageUrl() }}">
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
                                $startPage = max($mergedData->currentPage() - $showPages, 1);
                                $endPage = min($mergedData->currentPage() + $showPages, $mergedData->lastPage());
                            @endphp
    
                            @if ($startPage > 1)
                                <!-- Tampilkan Tombol Halaman Pertama Jika Ada Halaman Sebelumnya -->
                                <a href="{{ $mergedData->url(1) }}">
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
                                <a href="{{ $mergedData->url($i) }}">
                                    <button
                                        class="h-10 px-5 @if ($i == $mergedData->currentPage()) bg-utama text-white rounded-full @else text-utama hover:bg-green-100 rounded-full @endif transition-colors duration-150">
                                        {{ $i }}
                                    </button>
                                </a>
                            @endfor
    
                            @if ($endPage < $mergedData->lastPage())
                                <!-- Tampilkan Elipsis Jika Ada Halaman Selanjutnya Yang Tidak Ditampilkan -->
                                <span class="h-10 px-5 text-gray-400">...</span>
                                <!-- Tampilkan Tombol Halaman Terakhir Jika Ada Halaman Selanjutnya -->
                                <a href="{{ $mergedData->url($mergedData->lastPage()) }}">
                                    <button class="h-10 px-5 text-utama transition-colors duration-150 hover:bg-green-100 rounded-full">
                                        {{ $mergedData->lastPage() }}
                                    </button>
                                </a>
                            @endif
    
                            @if ($mergedData->hasMorePages())
                                <!-- Tombol Next Aktif -->
                                <a href="{{ $mergedData->nextPageUrl() }}">
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

    <div id="data-mahasiswa" data-get-nomor-ruangan="{{ route('admin.getNomorRuangan') }}">
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/absensiMahasiswa.js') }}"></script>
@endsection
