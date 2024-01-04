@extends('layouts.main')
@section('container')
    <div class="px-3 py-6 md:p-6 mb-5">
        <h1 class="font-semibold text-2xl md:text-3xl mb-3">Generate Laporan</h1>
        <div class="text-gray-600 text-sm">Cetak hasil laporan E-Absen Asarama Polbangtan-mlg</div>
        <div class="border-b border-gray-300 my-5"></div>
        <div class="bg-white rounded-lg p-3 py-6 mt-5 border-2">
            <form action="/generate-laporan" method="POST" class="w-full md:w-[70%] mx-0 md:mx-auto p-6 rounded-xl inner-sdw bg-utama">
                @csrf
                <h4 class="text-xl text-white font-semibold mb-4">Laporan Absen Siswa</h4>
                <div class="flex flex-col md:flex-row items-center mb-4">
                    <div class="w-full">
                        <label for="tanggalSiswa" class="text-lg font-semibold text-gray-200">Mingguan:</label>
                    </div>
                    <div class="w-full">
                        <input type="week" name="tanggalSiswa" id="tanggalSiswa"
                            class="w-full border rounded py-2 px-3" value="">
                    </div>
                </div>
                <div class="mb-4">
                    <select name="blok" class="w-full border-2 rounded border-utama py-2 px-3">
                        <option value="" hidden>-- Pilih Blok Ruangan --</option>
                        @foreach ($blok as $b)
                            <option value="{{ $b->id }}">Blok {{ $b->name }}</option>
                        @endforeach
                        <!-- Add more options here -->
                    </select>
                </div>
                <div class="text-red-500 mb-4"> <!-- Display error message here if needed -->
                    <div class="mt-4 flex flex-col">
                        <button type="submit" name="submit" value="pdf"
                            class="bg-teal-900 hover:bg-teal-800 text-white py-3 px-4 rounded flex items-center mb-2 text-md md:text-xl text-center">
                            <i class="ri-printer-fill mr-2"></i>
                            Generate PDF
                        </button>
                        <button type="submit" name="submit" value="excel"
                            class="bg-teal-900 hover:bg-teal-800 text-white py-3 px-4 rounded flex items-center mb-2 text-md md:text-xl text-center">
                            <i class="ri-printer-fill mr-2"></i>
                            Generate EXCEL
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
