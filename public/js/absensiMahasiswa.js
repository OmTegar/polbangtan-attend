$(document).ready(function() {
    $("#blok_ruangan").on("change", function() {
        // Dapatkan nilai yang dipilih oleh pengguna
        var selectedBlokRuanganId = $(this).val();
        
        // Lakukan permintaan AJAX untuk mengambil nomor ruangan berdasarkan blok ruangan yang dipilih
        $.ajax({
            url: "/absensi-mahasiswa/getNomorRuangan", // Ganti dengan URL yang sesuai dengan endpoint Anda
            type: "GET",
            data: { blok_ruangan: selectedBlokRuanganId },
            success: function(data) {
                // Update elemen select nomor ruangan dengan opsi yang diterima dari server
                $("#nomor_ruangan").empty(); // Kosongkan elemen select terlebih dahulu
                $("#nomor_ruangan").append("<option value='' selected hidden>-</option>"); // Tambahkan opsi
                $.each(data, function(key, value) {
                    $("#nomor_ruangan").append("<option selected hidden>Pilih ruangan</option>" + "<option value='" + value + "'>" + value + "</option>");
                });
                
            },
            error: function() {
                console.log("Terjadi kesalahan saat mengambil data nomor ruangan.");
            }
        }); 
    });

    $("#nomor_ruangan").on("change", function() {
        // Setel ulang elemen tabel atau lakukan permintaan AJAX lainnya jika diperlukan
        refreshTable();
    });

    function updateTable(data) {
        var tableBody = $('#result');
        tableBody.empty();
    
        $.each(data.data, function(index, item) {
            var presenceStatus = '';
            if (item.status) {
                if (item.status === 'didalam') {
                    presenceStatus = '<div class="bg-green-500 text-white rounded p-1 text-center">Di dalam Asrama</div>';
                } else if (item.status === 'diluar') {
                    presenceStatus = '<div class="bg-red-500 text-white rounded p-1 text-center">Di luar Asrama</div>';
                } else if (item.status === 'telat') {
                    presenceStatus = '<div class="bg-orange-500 text-white rounded p-1 text-center">Telat Masuk Asrama</div>';
                }
            } else {
                presenceStatus = '<div class="bg-red-500 text-white rounded p-1 text-center">Belum Absen</div>';
            }
    
            var presenceKeluar = '';
            if (item.presence_keluar && item.presence_keluar !== '-') {
                var presenceKeluarArray = item.presence_keluar.split(',');
                $.each(presenceKeluarArray, function(i, presence) {
                    presenceKeluar += '<div class="py-1">' + presence + '</div>';
                });
            } else {
                presenceKeluar = '-';
            }
    
            var presenceMasuk = '';
            if (item.presence_masuk && item.presence_masuk !== '-') {
                var presenceMasukArray = item.presence_masuk.split(',');
                $.each(presenceMasukArray, function(i, presence) {
                    presenceMasuk += '<div class="py-1">' + presence + '</div>';
                });
            } else {
                presenceMasuk = '-';
            }
    
            var row = '<tr class="bg-white border-b">' +
                '<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">' + (index + 1) + '</th>' +
                '<td class="px-6 py-4">' + item.nim + '</td>' +
                '<td class="px-6 py-4">' + item.name + '</td>' +
                '<td class="px-6 py-4">' + presenceStatus + '</td>' +
                '<td class="px-6 py-4">' + presenceKeluar + '</td>' +
                '<td class="px-6 py-4">' + presenceMasuk + '</td>' +
                '<td class="px-6 py-4">' + new Date().toLocaleDateString('en-US', { day: 'numeric', month: 'long', year: 'numeric' }) + '<br></td>' +
                '</tr>';
    
            tableBody.append(row);
        });
    }
    
    

    function refreshTable() {
        var selectedBlokRuanganId = $("#blok_ruangan").val();
        var selectedNomorRuangan = $("#nomor_ruangan").val();
        
        // Lakukan permintaan AJAX untuk mengambil data tabel berdasarkan filter yang dipilih
        $.ajax({
            url: "/absensi-mahasiswa/getDataAbsen", // Ganti dengan URL yang sesuai untuk mengambil data tabel
            type: "GET",
            data: { blok_ruangan: selectedBlokRuanganId, nomor_ruangan: selectedNomorRuangan },
            success: function(data) {
                // Update tabel dengan data yang diterima dari server
                updateTable(data);
                // console.log(data);
            },
            error: function() {
                console.log("Terjadi kesalahan saat mengambil data absen.");
            }
        });
    }

});