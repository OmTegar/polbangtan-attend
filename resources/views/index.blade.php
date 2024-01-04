@extends('layouts.main')
@section('container')
<!-- start: Main -->
<div class="px-3 py-6 md:p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between">
                <div>
                    <div class="text-xl font-semibold mb-12">Pengguna Aktif</div>
                    <div class="text-sm font-medium text-green-700 flex items-center">
                        <span class="relative flex h-3 w-3 mr-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                        {{ $activeuser }} Pengguna
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between">
                <div>
                    <div class="text-xl font-semibold mb-12">Total Pengguna</div>
                    <div class="text-sm font-medium text-amber-700 flex items-center">
                        <div class="w-3 h-3 rounded-full bg-amber-500 animate-pulse mr-2"></div>
                        {{ $totaluser }} Pengguna
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between">
                <div>
                    <div class="text-xl font-semibold mb-12">Piket pada hari ini</div>
                    <div class="text-sm font-medium text-utama flex items-center m-1">
                        {{ $petugas1 }}
                    </div>
                    <div class="text-sm font-medium text-utama flex items-center m-1">
                        {{ $petugas2 }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col justify-between gap-5">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="flex justify-between mb-4 items-start">
                <div class="font-medium">Status Presensi</div>
            </div>
            <div class="overflow-x-auto">
                <!-- Alasan Presensi -->
                <div class="flex flex-col md:flex-row justify-normal md:justify-between">
                    <!-- Icon -->
                    {{-- jika is_active sama dengan 1 dan null --}}
                    @if ($status->status == "diluar")
                        <div class="flex items-center">
                            <i class="ri-information-line text-utama text-6xl mr-2"></i>
                            <!-- Keterangan Alasan -->
                            <div>
                                <h3 class="text-lg font-semibold">Berada Diluar Asrama</h3>
                            </div>
                        </div>
                        <div class="text-sm mt-5 md:mt-0 text-gray-500">
                            Batas Waktu Keluar:<br> 
                            Jam 06.00 WIB - Jam 22.00 WIB
                        </div> 
                    @endif
                    @if ($status->status == "didalam")
                        <div class="flex items-center">
                            <i class="ri-shield-check-line text-utama text-6xl mr-2"></i>
                            <!-- Keterangan Alasan -->
                            <div>
                                <h3 class="text-lg font-semibold">Berada Diarea Asrama</h3>
                            </div>
                        </div>
                        <div class="text-sm mt-5 md:mt-0 text-gray-500">
                            Batas Waktu Keluar:<br> 
                            Jam 06.00 WIB - Jam 22.00 WIB
                        </div> 
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6 mt-6">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md lg:col-span-2">
            <div class="flex justify-between mb-4 items-start">
                <div class="font-medium">Kalender Stastik</div>
            </div>
            <div class="overflow-x-auto">
                <div id="calendar" class="m-2 text-sm md:text-lg"></div> 
            </div>   
        </div>
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md h-auto] lg:h-[30%]">
            <div class="flex justify-between mb-4 items-start">
                <div class="font-medium">Berikut detail rekapan Anda</div>
            </div>
            <div class="overflow-x-auto">
                <div class="w-full bg-utama rounded">
                    <ul class="list-group">
                        <!-- Data "Keluar" -->
                        <li class="list-group-item flex justify-between items-center p-3">
                            <span class="text-white text-sm">Berada diluar asrama</span>
                            @if ($total_days)
                            <span class="badge bg-red-500 text-sm text-white p-1 rounded">{{ $total_days }} <small>Hari</small></span>
                            @else
                            <span class="badge bg-red-500 text-sm text-white p-1 rounded">0 <small>Hari</small></span>
                            @endif
                            
                        </li>
                    </ul>
                </div> 
            </div>
        </div>
    </div>
</div>
<!-- end: Main -->
<script src="{{ asset('js/kalendar.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
@endsection